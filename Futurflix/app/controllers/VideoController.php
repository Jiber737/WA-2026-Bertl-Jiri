<?php
require_once '../core/Controller.php';
// Načteme našeho nového "skladníka"
require_once '../app/models/Video.php'; 

class VideoController extends Controller {

    protected function addSuccessMessage($message) {
        $_SESSION['messages']['success'][] = $message;
    }

    protected function addNoticeMessage($message) {
        $_SESSION['messages']['notice'][] = $message;
    }

    protected function addErrorMessage($message) {
        $_SESSION['messages']['error'][] = $message;
    }
    
    public function create() {
        require_once '../app/views/webpages/video_create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // 1. Získáme URL z formuláře a "vykousneme" z ní 11-místné ID
            $url = $_POST['youtube_url'];
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
            
            $youtube_id = isset($match[1]) ? $match[1] : null;

            // Pokud vzoreček nenašel ID, uživatel zadal nesmyslnou adresu
            // Pokud vzoreček nenašel ID, uživatel zadal nesmyslnou adresu
            if (!$youtube_id) {
                echo "<script>
                        alert('Chyba: Zadal jsi neplatný YouTube odkaz!');
                        window.history.back();
                    </script>";
                exit;
            }

            // 2. Nahrání obrázku na server
            $imageName = $this->processImageUpload();
            

            // 3. Ošetření vstupů
            $title        = htmlspecialchars($_POST['title']);
            $description  = htmlspecialchars($_POST['description']);
            $genre        = htmlspecialchars($_POST['genre']);
            $release_year = (int)$_POST['release_year'];
            $age_rating   = htmlspecialchars($_POST['age_rating']);

            // 4. Uložení do databáze (předáváme proměnnou $youtube_id)
            $isCreated = $this->getModel()->create(
                $title, 
                $youtube_id, // <-- Předáváme jen ID, jak vyžaduje databáze
                $description, 
                $genre, 
                $release_year, 
                $age_rating, 
                $imageName, 
                $_SESSION['user_id'] // <-- TOTO JE NOVÉ: Předáváme ID tvůrce
            );
            
            if ($isCreated) {
                $this->addSuccessMessage('Video bylo úspěšně přidáno.');
                header("Location: " . BASE_URL . "/index.php");
                exit; 
            } else {
                echo "<h2 style='color:red; text-align:center;'>Jejda, něco se pokazilo v databázi.</h2>";
            }
        }
    }

    private function processImageUpload() {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            
            // Cesta ke složce s uploady (přizpůsob podle struktury projektu)
            $uploadDir = __DIR__ . '/../../public/uploads/';
            
            // Vytvoří složku, pokud ještě neexistuje
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = basename($_FILES['image']['name']);
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            
            // Povolené formáty obrázků
            $allowedExts = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($fileExt, $allowedExts)) {
                // Vygenerujeme unikátní název pro soubor, aby se nepřepisovaly existující
                $newFileName = uniqid('video_') . '.' . $fileExt;
                $destination = $uploadDir . $newFileName;

                // Přesuneme dočasný soubor na jeho finální místo
                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    return $newFileName; // Vrátíme název pro uložení do databáze
                }
            }
        }
        return null;
        
    }

    private function getModel() {
        require_once '../app/models/Database.php';
        require_once '../app/models/Video.php';
        $db = (new Database())->getConnection();
        return new Video($db);
    }

    // Metoda pro načtení editačního formuláře
    public function edit($id = null) {
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID videa k úpravě.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Video.php';

        $database = new Database();
        $db = $database->getConnection();
        $videoModel = new Video($db);
        $video = $videoModel->getById($id);

        if (!$video) {
            $this->addErrorMessage('Požadované video nebylo nalezeno.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // 💡 ZMĚNA: Načtení práv ze Session
        $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
        $isAuthor = isset($_SESSION['user_id']) && isset($video['user_id']) && $video['user_id'] == $_SESSION['user_id'];

        // 🛡️ ZMĚNA: Pokud uživatel není autor a zároveň není admin, vyhodíme ho
        if (!$isAuthor && !$isAdmin) {
            $this->addErrorMessage('Nemáš oprávnění upravovat toto video.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Vytvoříme pro formulář novou položku 'youtube_url' složením základu a ID z databáze
        $video['youtube_url'] = "https://www.youtube.com/watch?v=" . $video['youtube_id'];
        require_once '../app/views/webpages/video_edit.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Načteme video, abychom zkontrolovali, komu patří
            $videoModel = $this->getModel();
            $video = $videoModel->getById($id);

            if (!$video) {
                $this->addErrorMessage('Video nebylo nalezeno.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            // 💡 ZMĚNA: Kontrola oprávnění před uložením úprav
            $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
            $isAuthor = isset($_SESSION['user_id']) && isset($video['user_id']) && $video['user_id'] == $_SESSION['user_id'];

            if (!$isAuthor && !$isAdmin) {
                $this->addErrorMessage('Nemáš oprávnění upravovat toto video.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            // 1. Zjistíme, jestli uživatel nahrál nový obrázek, nebo ponecháme starý
            $url = $_POST['youtube_url'];
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
            $youtube_id = isset($match[1]) ? $match[1] : null;

            if (!$youtube_id) {
                echo "<script>
                        alert('Chyba: Zadal jsi neplatný YouTube odkaz!');
                        window.history.back();
                    </script>";
                exit;
            }
            
            $imageName = $this->processImageUpload() ?: $_POST['old_image'];

            // 2. Bezpečné načtení dat z formuláře (přiřazení do proměnných)
            $title        = htmlspecialchars($_POST['title']);
            $description  = htmlspecialchars($_POST['description']);
            $genre        = htmlspecialchars($_POST['genre']);
            $release_year = (int)$_POST['release_year'];
            $age_rating   = htmlspecialchars($_POST['age_rating']);

            // 3. Zavolání metody v modelu (přesně tak, jak jsi zvyklý z BooksApp)
            $this->getModel()->update(
                $id, 
                $title, 
                $youtube_id, // TADY posíláme vypreparované ID, ne celou URL                
                $description, 
                $genre, 
                $release_year, 
                $age_rating, 
                $imageName
            );

            // 4. Přesměrování zpět na hlavní stranu
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
    }


    public function show($id = null) {
        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Video.php';
        require_once '../app/models/Comment.php'; //Načteme i model komentářů

        $database = new Database();
        $db = $database->getConnection();
        $videoModel = new Video($db);
        $commentModel = new Comment($db); //Instance komentářů
        
        // Načtení dat o videu podle ID
        $video = $videoModel->getById($id);

        if (!$video) {
            die("Video nebylo nalezeno.");
        }

        // 💡 ZMĚNA: Načtení komentářů k tomuto videu
        $comments = $commentModel->getByVideoId($id);

        // 💡 ZMĚNA: Předání obou proměnných do view
        $data = [
            'video' => $video,
            'comments' => $comments
        ];
        require_once '../app/views/webpages/video_view.php';
    }


    public function delete($id = null) {
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID videa ke smazání.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Video.php';

        $database = new Database();
        $db = $database->getConnection();
        $videoModel = new Video($db);

        // Načteme info o videu kvůli smazání souboru
        $video = $videoModel->getById($id);

        if (!$video) {
            $this->addErrorMessage('Video nebylo nalezeno.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // 💡 ZMĚNA: Ochrana proti neoprávněnému smazání
        $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
        if (!isset($_SESSION['user_id']) || ($video['user_id'] !== $_SESSION['user_id'] && !$isAdmin)) {
            $this->addErrorMessage('Nemáš oprávnění smazat toto video.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
        
        if ($video && !empty($video['image'])) {
            $imagePath = __DIR__ . '/../../public/uploads/' . $video['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath); // Smaže soubor z disku
            }
        }

        $isDeleted = $videoModel->delete($id);

        if ($isDeleted) {
            $this->addSuccessMessage('Video bylo trvale smazáno.');
        } else {
            $this->addErrorMessage('Chyba: Video se nepodařilo smazat.');
        }

        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }


    // 6. Zobrazení profilu uživatele a jeho vlastních videí
    public function profile() {
        // 🛡️ Ochrana: Pokud uživatel není přihlášen, nepustíme ho sem
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro zobrazení profilu se musíš nejdříve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/User.php';
        require_once '../app/models/Video.php';
        
        $db = (new Database())->getConnection();
        $userModel = new User($db);
        $videoModel = new Video($db);

        // Načteme kompletní info o uživateli (jméno, email, nickname...)
        $user = $userModel->findById($_SESSION['user_id']);
        // Načteme pouze videa tohoto konkrétního uživatele
        $videos = $videoModel->getByUserId($_SESSION['user_id']);

        // Načtení samotného vzhledu profilu
        require_once '../app/views/webpages/my_profile.php';
    }

}