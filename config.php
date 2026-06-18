<?php
// ============================================================
// TableCrown — config.php
// File di configurazione globale del progetto.
// Modifica solo questo file per cambiare ambiente.
// ============================================================

// ── AMBIENTE ────────────────────────────────────────────────
// Cambia in 'production' quando vai live
define('ENVIRONMENT', 'development');

// ── BASE URL ─────────────────────────────────────────────────
// development: punta al server locale
// production:  punta al dominio reale
if (ENVIRONMENT === 'development') {
    define('BASE_URL', 'http://localhost:8000');
} else {
    define('BASE_URL', 'https://www.tablecrown.it');
}

// ── PERCORSI FISICI ──────────────────────────────────────────
define('ROOT_PATH',       __DIR__);
define('PUBLIC_PATH',     __DIR__ . '/public');
define('CSS_PATH',        PUBLIC_PATH . '/css');
define('JS_PATH',         PUBLIC_PATH . '/js');
define('IMG_PATH',        PUBLIC_PATH . '/img');
define('PRESENTATION_PATH', __DIR__ . '/Presentation');
define('SMARTY_DIR',      PRESENTATION_PATH . '/smarty-dir/');

// ── DATABASE ─────────────────────────────────────────────────
if (ENVIRONMENT === 'development') {
    define('DB_HOST',     'localhost');
    define('DB_NAME',     'tablecrown');
    define('DB_USER',     'root');
    define('DB_PASS',     '');
    define('DB_PORT',     3306);
} else {
    define('DB_HOST',     'localhost');
    define('DB_NAME',     'tablecrown_prod');
    define('DB_USER',     'tuo_utente_db');
    define('DB_PASS',     'tua_password_db');
    define('DB_PORT',     3306);
}

// ── SESSIONE ─────────────────────────────────────────────────
define('SESSION_NAME',    'tablecrown_session');
define('SESSION_LIFETIME', 3600); // 1 ora in secondi