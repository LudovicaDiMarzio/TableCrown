<?php
require_once __DIR__ . '/config.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// ────────────────────────────────────────────────────────────
// TOGGLE LOGIN DI TEST (solo development, da rimuovere poi)
// Visita: http://localhost:8000/?login=1  → simula utente loggato
// Visita: http://localhost:8000/?login=0  → simula visitatore anonimo
// ────────────────────────────────────────────────────────────
if (ENVIRONMENT === 'development' && isset($_GET['login'])) {
    if ($_GET['login'] === '1') {
        $_SESSION['utente_id']       = 1;
        $_SESSION['utente_nickname'] = 'TestUser';
    } else {
        unset($_SESSION['utente_id'], $_SESSION['utente_nickname']);
    }
}

// ────────────────────────────────────────────────────────────
// ENDPOINT MOCK: /carrello/aggiungi
// Da sostituire con il vero Controller quando sarà pronto.
// ────────────────────────────────────────────────────────────
if ($uri === '/carrello/aggiungi' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require __DIR__ . '/mock_carrello_aggiungi.php';
    exit;
}

// ────────────────────────────────────────────────────────────
// FILE STATICI (css, js, immagini, font...)
// ────────────────────────────────────────────────────────────
$staticFile = __DIR__ . DIRECTORY_SEPARATOR . 'public' . str_replace('/', DIRECTORY_SEPARATOR, $uri);




if (is_file($staticFile)) {
    $ext = strtolower(pathinfo($staticFile, PATHINFO_EXTENSION));
    $mime = [
        'css'   => 'text/css',
        'js'    => 'application/javascript',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'svg'   => 'image/svg+xml',
        'ico'   => 'image/x-icon',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
    ];
    if (isset($mime[$ext])) {
        header('Content-Type: ' . $mime[$ext]);
    }
    readfile($staticFile);
    exit;
}

// ────────────────────────────────────────────────────────────
// FILE PHP DIRETTI
// ────────────────────────────────────────────────────────────
$phpFile = __DIR__ . str_replace('/', DIRECTORY_SEPARATOR, $uri);
if (is_file($phpFile) && pathinfo($phpFile, PATHINFO_EXTENSION) === 'php') {
    require $phpFile;
    exit;
}

// ────────────────────────────────────────────────────────────
// DEFAULT: mostra la home di test
// ────────────────────────────────────────────────────────────
require __DIR__ . DIRECTORY_SEPARATOR . 'test_preview.php';