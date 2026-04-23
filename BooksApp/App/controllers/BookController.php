<?php
// Soubor: BooksApp/App/controllers/BookController.php

class BookController {

    // Zobrazení seznamu knih
       // 0. Výchozí metoda pro zobrazení úvodní stránky včetně seznamu knih
    public function index() {
        // Načtení potřebných tříd
        require_once '../app/models/Database.php';
        require_once '../app/models/Book.php';

        // Vytvoření připojení k databázi
        $database = new Database();
        $db = $database->getConnection();

        // Inicializace modelu a získání dat
        $bookModel = new Book($db);
        $books = $bookModel->getAll(); // Proměnná $books nyní obsahuje pole všech knih
        
        // Načte se (vloží) připravený soubor s HTML strukturou
        require_once '../app/views/books/books_list.php';
    }

    // Metoda pro zobrazení detailu konkrétní knihy
    public function show($id = null) {
        // Kontrola, zda bylo předáno ID
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID knihy k zobrazení.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení potřebných tříd a spojení s databází
        require_once '../App/models/Database.php';
        require_once '../App/models/Book.php';

        $database = new Database();
        $db = $database->getConnection();

        // Inicializace modelu a získání dat o knize
        $bookModel = new Book($db);
        $book = $bookModel->getById($id); 

        // Bezpečnostní kontrola, zda kniha existuje
        if (!$book) {
            $this->addErrorMessage('Kniha nebyla nalezena.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení šablony pro detail knihy
        require_once '../App/views/books/book_show.php';
    }

    // Metoda pro zobrazení formuláře
    public function create() {
        if (!isset($_SESSION['user_id'])) {
        $this->addErrorMessage('Pro přidání knihy se musíte nejprve přihlásit.');
        header('Location: ' . BASE_URL . '/index.php?url=auth/login');
        exit;
    }
        require_once '../App/views/books/book_create.php';
    }

    // Metoda pro zpracování dat z formuláře
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

             // !!! ZMĚNA: ZDE PŘIDÁME KONTROLU PŘIHLÁŠENÍ ---
            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('Pro uložení knihy musíte být přihlášeni.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }
            $userId = $_SESSION['user_id'];
            // ---------------------------------------

            // 1. Získání a očištění textových dat
            $title = htmlspecialchars($_POST['title'] ?? '');
            $author = htmlspecialchars($_POST['author'] ?? '');
            $isbn = htmlspecialchars($_POST['isbn'] ?? '');
            $category = htmlspecialchars($_POST['category'] ?? '');
            $subcategory = htmlspecialchars($_POST['subcategory'] ?? '');
            $year = (int)($_POST['year'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            $link = htmlspecialchars($_POST['link'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');

            // Zpracování nahraných souborů
            $uploadedImages = $this->processImageUploads();

            // 2. Komunikace s databází a modelem
            require_once '../app/models/Database.php';
            require_once '../app/models/Book.php';

            $database = new Database();
            $db = $database->getConnection();

            $bookModel = new Book($db);
            
            // !!! ZMĚNA: ZDE PŘIDÁME $userId jako poslední argument volání metody
            $isSaved = $bookModel->create(
                $title, $author, $category, $subcategory, 
                $year, $price, $isbn, $description, $link, $uploadedImages,
                $userId // PŘEDÁVÁME ID UŽIVATELE
            );

            // 3. Vyhodnocení výsledku a přesměrování
            if ($isSaved) {
                $this->addSuccessMessage('Kniha byla úspěšně uložena.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                $this->addErrorMessage('Nepodařilo se uložit knihu do databáze.');
            }
            
        } 
        
        else {
            $this->addNoticeMessage('Pro přidání knihy je nutné odeslat formulář.');

            require_once '../App/models/Book.php';
            $bookModel = new Book();

            // --- ZPRACOVÁNÍ OBRÁZKŮ ---
            $uploadedImages = [];
            // Zkontrolujeme, zda vůbec existuje pole $_FILES a zda byl nahrán alespoň jeden soubor
            if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                
                // Cesta k vaší složce uploads (pokud je index.php v public, uploads je v public/uploads)
                $targetDir = "uploads/"; 
                
                // Projdeme všechny nahrané soubory (uživatel jich může vybrat více)
                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    // Pokud nedošlo k chybě při nahrávání
                    if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                        
                        // Získáme původní jméno a přidáme k němu aktuální čas, aby bylo vždy unikátní
                        $originalName = basename($_FILES['images']['name'][$key]);
                        $uniqueName = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "", $originalName);
                        $targetFilePath = $targetDir . $uniqueName;

                        // Fyzický přesun souboru z dočasné paměti do naší složky uploads
                        if (move_uploaded_file($tmp_name, $targetFilePath)) {
                            // Uložíme si unikátní název souboru do pole
                            $uploadedImages[] = $uniqueName;
                        }
                    }
                }
            }
            // --------------------------

            // Sběr dat z POST
            $bookData = [
                'title' => $_POST['title'] ?? '',
                'author' => $_POST['author'] ?? '',
                'category' => $_POST['category'] ?? '',
                'subcategory' => $_POST['subcategory'] ?? '',
                'isbn' => $_POST['isbn'] ?? '',
                'year' => $_POST['year'] ?? 0,
                'price' => $_POST['price'] ?? 0,
                'description' => $_POST['description'] ?? '',
                // Obrázky převedeme na JSON text, aby se daly uložit do jednoho políčka v databázi
                'images' => json_encode($uploadedImages)
            ];

            // Volání metody create v modelu
            if ($bookModel->create($bookData)) {
                $this->addSuccessMessage('Kniha byla i s obrázky uložena.');
                header('Location: ' . BASE_URL . '/index.php');
                exit();
            } else {
                $this->addErrorMessage("Chyba při ukládání knihy do databáze.");
                header('Location: ' . BASE_URL . '/index.php');
                exit();
            }
        }
    }

            // 3. Smazání existující knihy
    public function delete($id = null) {
        // Kontrola, zda bylo v URL předáno ID

        if (!isset($_SESSION['user_id'])) //jestli je uzivatel prihlasen zkouma pomoci superglobalni promenne
            {
        $this->addErrorMessage('Pro smazání knihy se musíte nejprve přihlásit.');
        header('Location: ' . BASE_URL . '/index.php?url=auth/login');
        exit;
    }

        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID knihy ke smazání.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení potřebných tříd a spojení s databází
        require_once '../app/models/Database.php';
        require_once '../app/models/Book.php';

        $database = new Database();
        $db = $database->getConnection();

        // Inicializace modelu a zavolání metody pro smazání
        $bookModel = new Book($db);
        $isDeleted = $bookModel->delete($id);

        // Vyhodnocení výsledku a přesměrování s notifikací
        if ($isDeleted) {
            // Zelená zpráva o úspěchu
            $this->addSuccessMessage('Kniha byla trvale smazána z databáze.');
        } else {
            // Červená zpráva pro případ, že kniha neexistovala nebo selhal dotaz
            $this->addErrorMessage('Nastala chyba. Knihu se nepodařilo smazat.');
        }

        // Vždy následuje návrat na seznam knih
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

        // 4. Zobrazení formuláře pro úpravu existující knihy
    public function edit($id = null) {
        // Kontrola, zda bylo v URL vůbec předáno nějaké ID

        if (!isset($_SESSION['user_id'])) {
        $this->addErrorMessage('Pro přidání knihy se musíte nejprve přihlásit.');
        header('Location: ' . BASE_URL . '/index.php?url=auth/login');
        exit;
        }

        if (!$id) {
            // Vyvolání červené notifikace pro kritickou chybu
            $this->addErrorMessage('Nebylo zadáno ID knihy k úpravě.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení potřebných tříd a spojení s databází
        require_once '../app/models/Database.php';
        require_once '../app/models/Book.php';

        $database = new Database();
        $db = $database->getConnection();

        // Získání dat o konkrétní knize
        $bookModel = new Book($db);
        $book = $bookModel->getById($id); // Proměnná $book nyní obsahuje asociativní pole dat


        $uploadedImages = $this->processImageUploads();

        // Bezpečnostní kontrola: Zda kniha s daným ID vůbec existuje
        if (!$book) {
            // Pokud knihu někdo mezitím smazal, nebo uživatel zadal do URL neexistující ID
            $this->addErrorMessage('Požadovaná kniha nebyla v databázi nalezena.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Pokud je vše v pořádku, načte se připravený soubor s HTML formulářem pro úpravy.
        // Šablona bude mít automaticky přístup k proměnné $book.
        require_once '../app/views/books/book_edit.php';
    }

        // 5. Zpracování dat odeslaných z editačního formuláře
    public function update($id = null) {
        // Zabezpečení: Je k dispozici ID a byl odeslán formulář?
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID knihy k aktualizaci.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 1. Získání a očištění textových dat
            $title = htmlspecialchars($_POST['title'] ?? '');
            $author = htmlspecialchars($_POST['author'] ?? '');
            $isbn = htmlspecialchars($_POST['isbn'] ?? '');
            $category = htmlspecialchars($_POST['category'] ?? '');
            $subcategory = htmlspecialchars($_POST['subcategory'] ?? '');
            
            // Přetypování číselných hodnot
            $year = (int)($_POST['year'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            
            $link = htmlspecialchars($_POST['link'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');

            // --- NOVÁ LOGIKA PRO SPRÁVU OBRÁZKŮ ---
            // 1. Získání obrázků, které chceme PONECHAT (ty, které zůstaly zaškrtnuté)
            $keepImages = $_POST['keep_images'] ?? [];

            // 2. Zpracování případných NOVÝCH obrázků (pokud uživatel nějaké nahrál)
            $newUploads = $this->processImageUploads(); 

            // 3. Sloučení obou polí do jednoho finálního seznamu (staré ponechané + zbrusu nové)
            $finalImages = array_merge($keepImages, $newUploads);
            // --------------------------------------

            // 2. Komunikace s databází a modelem
            require_once '../app/models/Database.php';
            require_once '../app/models/Book.php';

            $database = new Database();
            $db = $database->getConnection();

            // 3. Volání updatu nad modelem
            $bookModel = new Book($db);
            $isUpdated = $bookModel->update(
                $id, $title, $author, $category, $subcategory, 
                $year, $price, $isbn, $description, $link, $finalImages // Tady posíláme náš sloučený seznam
            );

            // 4. Vyhodnocení výsledku a přesměrování
            if ($isUpdated) {
                // Vyvolání zelené notifikace o úspěchu
                $this->addSuccessMessage('Kniha byla úspěšně upravena.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                // Vyvolání červené chybové notifikace
                $this->addErrorMessage('Nastala chyba. Změny se nepodařilo uložit.');
            }
            
        } else {
            // Pokud by někdo zkusil přistoupit na URL napřímo bez odeslání formuláře (žlutá notifikace)
            $this->addNoticeMessage('Pro úpravu knihy je nutné odeslat formulář.');
        }
    }
       // --- Pomocné metody pro systém notifikací ---

    protected function addSuccessMessage($message) {
        // Zelená zpráva o úspěchu
        $_SESSION['messages']['success'][] = $message;
    }

    protected function addNoticeMessage($message) {
        // Žlutá informativní zpráva
        $_SESSION['messages']['notice'][] = $message;
    }

    protected function addErrorMessage($message) {
        // Červená chybová zpráva
        $_SESSION['messages']['error'][] = $message;
    }

        // --- Pomocná metoda pro zpracování nahrávání obrázků ---
    protected function processImageUploads() {
        $uploadedFiles = [];
        
        // Cesta ke složce, kam se budou obrázky fyzicky ukládat (relativně od index.php)
        $uploadDir = __DIR__ . '/../../public/uploads/'; 
        
        // Zkontrolujeme, zda vůbec existuje adresář, pokud ne, vytvoříme ho
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Zkontrolujeme, zda byl odeslán alespoň jeden soubor
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $fileCount = count($_FILES['images']['name']);

            for ($i = 0; $i < $fileCount; $i++) {
                // Pokud při nahrávání tohoto konkrétního souboru nedošlo k chybě
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    
                    $tmpName = $_FILES['images']['tmp_name'][$i];
                    $originalName = basename($_FILES['images']['name'][$i]);
                    // Zjištění koncovky (např. jpg, png)
                    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                    // Můžeme zde přidat i kontrolu povolených formátů (volitelné)
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                    if (!in_array($fileExtension, $allowedExtensions)) {
                        continue; // Přeskočíme nepodporovaný soubor
                    }

                    // 1. Vygenerování unikátního jména pomocí aktuálního času a náhodného řetězce
                    // např: book_64a2b1c_8f2a.jpg
                    $newName = 'book_' . uniqid() . '_' . substr(md5(mt_rand()), 0, 4) . '.' . $fileExtension;
                    $targetFilePath = $uploadDir . $newName;

                    // 2. Fyzický přesun souboru z dočasné paměti do naší složky uploads
                    if (move_uploaded_file($tmpName, $targetFilePath)) {
                        // 3. Uložení POUZE NÁZVU do pole, které pak pošleme databázi
                        $uploadedFiles[] = $newName; 
                    }
                }
            }
        }
        return $uploadedFiles;
    }

    }
