<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Prova a servire il file da /public
$staticFile = __DIR__ . DIRECTORY_SEPARATOR . 'public' . str_replace('/', DIRECTORY_SEPARATOR, $uri);

if (is_file($staticFile)) {
    // Determina il MIME type corretto
    $ext = strtolower(pathinfo($staticFile, PATHINFO_EXTENSION));
    $mime = [
        'css'  => 'text/css',
        'js'   => 'application/javascript',
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif'  => 'image/gif',
        'svg'  => 'image/svg+xml',
        'ico'  => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2'=> 'font/woff2',
        'ttf'  => 'font/ttf',
    ];
    
    if (isset($mime[$ext])) {
        header('Content-Type: ' . $mime[$ext]);
    }
    
    readfile($staticFile);
    exit;
}

// Altrimenti esegui il file PHP richiesto
$phpFile = __DIR__ . str_replace('/', DIRECTORY_SEPARATOR, $uri);
if (is_file($phpFile) && pathinfo($phpFile, PATHINFO_EXTENSION) === 'php') {
    require $phpFile;
    exit;
}

// Default
require __DIR__ . DIRECTORY_SEPARATOR . 'test_preview.php';