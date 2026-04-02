<?php   

session_start();

//pro ucely ladeni na lokalnim serveru xampp
//kompletni zobrazovani chby
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Dynamické zjištění základní adresy aplikace
// Vypočítá absolutní cestu ke složce, ve které běží tento index.php
$baseDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
define('BASE_URL', $baseDir);
//echo($baseDir);

// Základní nastavení pro autoloading tříd postará se o ypracování URL
require_once '../core/App.php';

$app = new App(); //nefungoval by bez radku 8
