<?php
// ============================================================
// TableCrown — config.php
// File di configurazione globale del progetto.
// Modifica solo questo file per cambiare ambiente.
// ============================================================

// ── AMBIENTE ────────────────────────────────────────────────
// Cambia solo questa riga quando passi a produzione:
// 'development' → 'production'

//CODICE PER TEST SU XAMPP
define('ENVIRONMENT', 'development');
//define('ENVIRONMENT', 'production'); //development

// ── BASE URL ─────────────────────────────────────────────────
if (ENVIRONMENT === 'development') {
    define('BASE_URL', 'http://localhost/TableCrown');
} else {
    define('BASE_URL', 'https://tablecrown.alwaysdata.net');
}

// ── PERCORSI FISICI (uguali in ogni ambiente) ─────────────────
/*
define('ROOT_PATH',         __DIR__);
define('PUBLIC_PATH',       __DIR__ . '/public');
define('ASSETS_URL', BASE_URL . '/public');
define('CSS_PATH',   ASSETS_URL . '/css');
define('JS_PATH',    ASSETS_URL . '/js');
define('IMG_PATH',   ASSETS_URL . '/img');
define('PRESENTATION_PATH', __DIR__ . '/Presentation');
define('SMARTY_DIR',        PRESENTATION_PATH . '/smarty-dir/');
*/


//-----CODCE PER TEST SU XAMPP

define('ROOT_PATH',         __DIR__);
define('PUBLIC_PATH',       __DIR__ . '/public');
define('ASSETS_URL', BASE_URL . '/public');
define('CSS_PATH',   PUBLIC_PATH . '/css');
define('JS_PATH',    PUBLIC_PATH . '/js');
define('IMG_PATH',   PUBLIC_PATH . '/img');
define('PRESENTATION_PATH', __DIR__ . '/Presentation');
define('SMARTY_DIR',        PRESENTATION_PATH . '/smarty-dir/');
 

// ── DATABASE ─────────────────────────────────────────────────


if (ENVIRONMENT === 'development') {
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'tablecrown');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_PORT', 3306);
} else {
    define('DB_HOST', 'mysql-tablecrown.alwaysdata.net');
    define('DB_NAME', 'tablecrown_db');
    define('DB_USER', 'tablecrown');
    define('DB_PASS', 'cabletrown');
    define('DB_PORT', 3306);
}

// ── SESSIONE ─────────────────────────────────────────────────
define('SESSION_NAME',    'tablecrown_session');
define('SESSION_LIFETIME', 3600); // 1 ora in secondi

// Avvia la sessione PHP — serve a simulare login/logout
// in locale e servirà davvero quando Control gestirà l'auth.
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}