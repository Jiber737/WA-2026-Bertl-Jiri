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
        // Zkontrolujeme, jestli sem uživatel opravdu poslal formulář
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // 1. KOUZLO: Extrakce YouTube ID z URL (např. z https://www.youtube.com/watch?v=dQw4w9WgXcQ získáme dQw4w9WgXcQ)
            $url = $_POST['youtube_url'];
            // Tento "hrůzostrašný" kód je regulární výraz - profi detektiv, co najde ID v jakémkoliv typu YT odkazu
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
            $youtube_id = isset($match[1]) ? $match[1] : null;

            if (!$youtube_id) {
                die("<h2 style='color:red; text-align:center;'>Chyba: Zadal jsi neplatný YouTube odkaz!</h2>");
            }

            // 2. Zabalíme všechna data do balíčku
            $data = [
                'youtube_id' => $youtube_id,
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'genre' => $_POST['genre'],
                'release_year' => $_POST['release_year'],
                'age_rating' => $_POST['age_rating']
                //'image' => $imageName
            ];

            // 3. Předáme balíček modelu, ať ho uloží
            $videoModel = new Video();
            
            if ($videoModel->create($data)) {
                // Přesměrování zpět na hlavní stránku
                header("Location: " . BASE_URL . "/index.php");
                exit; // Důležité: zastaví další vykonávání kódu
            }
             else {
                echo "<h2 style='color:red; text-align:center;'>Jejda, něco se pokazilo v databázi.</h2>";
            }
        }
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

        require_once '../app/views/webpages/video_edit.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 1. Zjistíme, jestli uživatel nahrál nový obrázek, nebo ponecháme starý
            $imageName = $this->processImageUpload() ?: $_POST['old_image'];

            // 2. Bezpečné načtení dat z formuláře (přiřazení do proměnných)
            $title        = htmlspecialchars($_POST['title']);
            $youtube_url  = htmlspecialchars($_POST['youtube_url']);
            $description  = htmlspecialchars($_POST['description']);
            $genre        = htmlspecialchars($_POST['genre']);
            $release_year = (int)$_POST['release_year'];
            $age_rating   = htmlspecialchars($_POST['age_rating']);

            // 3. Zavolání metody v modelu (přesně tak, jak jsi zvyklý z BooksApp)
            $this->getModel()->update(
                $id, 
                $title, 
                $youtube_url, 
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


}