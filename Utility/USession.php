<?php
namespace TableCrown\Utility;

class USession { 

    //Distrugge completamente la sessione - usato al logout
    //session_destroy() elimina i dati della sessione dal server, ma non il cookie
    public static function destroySession(): void { 
        session_destroy();
    }

    //Svuota tutte le variabili di sessione senza distruggere la sessione
    //utile per "resettare" lo stato senza fare logout completo
    public static function unsetSession(): void {
        session_unset();
    }

    //Restituisce il valore di una variabile di sessione dato il suo nome
    //restituisce null se la variabile non esiste (grazie al ??)
    public static function getSessionElement(string $id): mixed {
        return $_SESSION[$id] ?? null;
    }

    //Elimina una singola variabile di sessione dato il suo nome
    //unset() rimuove la variabile dall'array $_SESSION
    public static function unsetSessionElement(string $id): void {
        unset($_SESSION[$id]);
    }

    //Imposta o aggiorna una variabile di sessione
    public static function setSessionElement(string $id, mixed $value): void {
        $_SESSION[$id] = $value;
    }

    //Verifica se una variabile di sessione esiste
    //isset() restituisce true se la variabile esiste e non è null
    public static function isSetSessionElement(string $id): bool {
        return isset($_SESSION[$id]);
    }

}