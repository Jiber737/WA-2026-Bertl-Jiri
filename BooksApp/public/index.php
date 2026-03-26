<?php   


//pro ucely ladeni na lokalnim serveru xampp
//kompletni zobrazovani chby
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Základní nastavení pro autoloading tříd postará se o ypracování URL
require_once '../core/App.php';

$app = new App(); //nefungoval by bez radku 8
