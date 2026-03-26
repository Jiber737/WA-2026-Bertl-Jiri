<?php

class BookController {

    //metoda pro zobrazení uvodni stranky
    public function index() {
        
        //vlozi se pripraveny soubor html
        require_once '../app/views/books/books_list.php';
    }

}