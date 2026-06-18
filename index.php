<?php
/**
 * Punto di ingresso unico dell'applicazione (Front Controller Pattern).
 */

//Imposta il timezone
date_default_timezone_set('Europe/Rome');

//Gestione della Sessione Globale
if (session_status() === PHP_SESSION_NONE) {
    session_start(); //Avvia la sessione globale
}

//Caricamento delle dipendenze
require_once __DIR__ . '/vendor/autoload.php';

use TableCrown\Control\CFrontController;
use TableCrown\Control\BaseController;
use TableCrown\Utility\UHTTPMethods;

//Cattura e pulizia della rotta virtuale passata dall'.htaccess
//Se l'utente richiede 'localhost/catalogo', $_GET['url'] sarà 'catalogo' -> viene trasformato in '/catalogo'
$url = isset($_GET['url']) ? '/' . rtrim($_GET['url'], '/') : '/';

//Inizializzazione e avvio del Front Controller
$frontController = new CFrontController();
$frontController->run($url);