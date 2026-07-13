<?php
namespace TableCrown\Utility;

class UCookie {
    /**
     * Crea o aggiorna un cookie sicuro.
     */
    public static function setCookie(string $name, string $value, int $days = 30): void {
        $expiry = time() + ($days * 24 * 60 * 60);
        //parametri: nome, valore, scadenza, percorso valido (tutto il sito), dominio, solo_http, secure
        setcookie($name, $value, $expiry, '/', 'tablecrown.it', false, true);
    }

    /**
     * Recupera il valore di un cookie.
     */
    public static function getCookie(string $name): ?string {
        return $_COOKIE[$name] ?? null;
    }

    /**
     * Cancella un cookie (impostando scadenza nel passato).
     */
    public static function deleteCookie(string $name): void {
        if (isset($_COOKIE[$name])) {
            setcookie($name, '', time() - 3600, '/');
            unset($_COOKIE[$name]);
        }
    }
}