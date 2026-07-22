<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Punto di ingresso unico dell'applicazione (Front Controller Pattern).
 */

//Imposta il timezone
date_default_timezone_set('Europe/Rome');

require_once __DIR__ . '/config.php';

//Caricamento delle dipendenze
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap.php';

use TableCrown\Control\CFrontController;
use TableCrown\Control\BaseController;
use TableCrown\Utility\UHTTPMethods;

//Cattura e pulizia della rotta virtuale passata dall'.htaccess

$url = isset($_GET['url']) ? '/' . rtrim($_GET['url'], '/') : '/';

// --- TEST DATABASE DA CANCELLARE DOPO ---
try {
    $em = getEntityManagerBoot();
    $em->getConnection()->connect();
    echo "<div style='background: green; color: white; padding: 10px;'>Connessione al Database: SUCCESSO!</div>";
} catch (\Exception $e) {
    echo "<div style='background: red; color: white; padding: 10px;'>ERRORE DATABASE: " . $e->getMessage() . "</div>";
    die(); // Blocca tutto e mostra l'errore
}
// ----------------------------------------


$frontController = new CFrontController();
$frontController->run($url);