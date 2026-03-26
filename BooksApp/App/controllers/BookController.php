<?php

class BookController {

    //metoda pro zobrazení uvodni stranky
    public function index() {
        
        //vlozi se pripraveny soubor html
        require_once '../app/views/books/books_list.php';
    }

    // Zobrazení formuláře pro přidání knihy
    public function create() {
        require_once '../app/views/books/book_create.php';
    }

    // Metoda, která zpracuje data z formuláře (POST)
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Načtení modelu
            require_once '../app/models/Book.php';
            $bookModel = new Book();

            // Příprava dat z $_POST
            $bookData = [
                'title' => $_POST['title'],
                'author' => $_POST['author'],
                'category' => $_POST['category'],
                'isbn' => $_POST['isbn'],
                'year' => $_POST['year'],
                'price' => $_POST['price'],
                'description' => $_POST['description']
            ];

            // Volání metody v modelu
            if ($bookModel->create($bookData)) {
                // Po úspěšném uložení přesměrujeme na seznam
                header('Location: /BooksApp/public/index.php?url=book/index');
            } else {
                echo "Chyba při ukládání knihy.";
            }
        }
    }
}
}