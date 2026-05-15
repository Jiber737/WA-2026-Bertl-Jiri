<?php
require_once '../core/Controller.php';
require_once '../app/models/Video.php'; // Načteme model

class HomeController extends Controller {

    public function index() {
            // 1. Načtení potřebných tříd
            //$_SESSION['messages']['success'][] = 'Test okna! Vidíš mě, Futurflixi?';

            require_once '../app/models/Database.php';
            require_once '../app/models/Video.php';

            // 2. Vytvoření připojení k databázi
            $database = new Database();
            $db = $database->getConnection();

            // 3. Inicializace modelu a získání dat o videích
            $videoModel = new Video($db);
            $videos = $videoModel->getAll(); // Proměnná $videos nyní obsahuje pole všech videí
            
            // 4. Načte se (vloží) připravený soubor s HTML strukturou
            require_once '../app/views/webpages/main_view.php';
        }
}