<?php
// Soubor: BooksApp/App/controllers/BookController.php

class BookController {

    // Zobrazení seznamu knih
    public function index() {
    require_once '../App/models/Book.php';
    $bookModel = new Book();
    
    // Získání všech knih z DB
    $books = $bookModel->getAll();
    
    // Načtení pohledu (proměnná $books v něm bude dostupná)
    require_once '../App/views/books/books_list.php';
}

    // Metoda pro zobrazení formuláře
    public function create() {
        require_once '../App/views/books/book_create.php';
    }

    // Metoda pro zpracování dat z formuláře
    public function store() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Načtení modelu - POZOR na velké "A" ve složce App
        require_once '../App/models/Book.php';
        $bookModel = new Book();

        // Zavolání metody v modelu (předáváme celý $_POST)
        if ($bookModel->create($_POST)) {
            // Pokud se povedlo, hodíme uživatele zpět na seznam
            header('Location: index.php?url=book/index');
            exit();
        } else {
            echo "Chyba: Nepodařilo se uložit knihu do databáze.";
        }
    }


            // Sběr dat z POST
            $bookData = [
                'title' => $_POST['title'],
                'author' => $_POST['author'],
                'category' => $_POST['category'],
                'isbn' => $_POST['isbn'],
                'year' => $_POST['year'],
                'price' => $_POST['price'],
                'description' => $_POST['description']
            ];

            // Volání metody create v modelu
            if ($bookModel->create($bookData)) {
                // Přesměrování zpět na seznam po úspěchu
                header('Location: /BooksApp/public/index.php?url=book/index');
                exit();
            } else {
                echo "Chyba při ukládání knihy do databáze.";
            }
        }
    }
