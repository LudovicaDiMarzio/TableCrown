<?php
namespace TableCrown\Utility;

use InvalidArgumentException;
use DateTime;

class UHTTPMethods {

    //Restituisce il metodo HTTP della richiesta corrente
    //$_SERVER['REQUEST_METHOD'] contiene 'GET', 'POST', ecc.
    public static function method(): ?string {
        return $_SERVER['REQUEST_METHOD'] ?? null;
    }

    //Recupera un parametro dall'URL (query string)
    //es. /catalogo?q=catan -> get('q') restituisce 'catan'
    //$default è il valore restituito se il parametro non esiste
    public static function get(string $param, mixed $default = null): mixed {
        return $_GET[$param] ?? $default;
    }

    //Recupera un parametro grezzo dal form POST senza validazione
    //utile quando si vuole solo sapere se il campo esiste, non validarlo
    public static function post(string $param, mixed $default = null): mixed {
        return $_POST[$param] ?? $default;
    }

    /**
     * Recupera e valida una stringa dal form POST
     * trim() rimuove gli spazi iniziali e finali
     * lancia un'eccezione se il campo è vuoto o troppo lungo
     */
    public static function postString(string $key, ?int $maxLength = null): string {
        $value = trim($_POST[$key] ?? '');
        if ($value === '') {
            throw new InvalidArgumentException("Il campo '$key' è richiesto.");
        }
        if ($maxLength !== null && strlen($value) > $maxLength) {
            throw new InvalidArgumentException("Il campo '$key' supera la lunghezza massima di $maxLength caratteri.");
        }
        return $value;
    }

    /**
     * Recupera e valida un numero intero dal form POST
     * is_numeric() verifica che il valore sia un numero
     * controlla che sia nel range min-max se specificati
     * lancia un'eccezione se il campo non è un numero
     */
    public static function postInt(string $key, ?int $min = null, ?int $max = null): int {
        if (!isset($_POST[$key]) || !is_numeric($_POST[$key])) {
            throw new InvalidArgumentException("Il campo '$key' deve essere un numero intero.");
        }
        $value = (int)$_POST[$key];
        if ($min !== null && $value < $min) {
            throw new InvalidArgumentException("Il campo '$key' deve essere maggiore di $min.");
        }
        if ($max !== null && $value > $max) {
            throw new InvalidArgumentException("Il campo '$key' deve essere minore di $max.");
        }
        return $value;
    }

    /**
     * Recupera e valida un float dal form POST
     * utile per prezzi, sconti, valutazioni, ecc.
     */
    public static function postFloat(string $key, ?float $min = null, ?float $max = null): float {
        if (!isset($_POST[$key]) || !is_numeric($_POST[$key])) {
            throw new InvalidArgumentException("Il campo '$key' deve essere un numero.");
        }
        $value = (float)$_POST[$key];
        if ($min !== null && $value < $min) {
            throw new InvalidArgumentException("Il campo '$key' deve essere maggiore di $min.");
        }
        if ($max !== null && $value > $max) {
            throw new InvalidArgumentException("Il campo '$key' deve essere minore di $max.");
        }
        return $value;
    }

    /**
     * Recupera e valida una data dal form POST
     * DateTime::createFromFormat() converte una stringa in un oggetto DateTime
     * usando il formato specificato (es. 'd/m/Y' per '01/01/2022')
     */
    public static function postDate(string $key, string $format = 'd/m/Y'): DateTime {
        $value = $_POST[$key] ?? '';
        $date = DateTime::createFromFormat($format, $value);
        if (!$date) {
            throw new InvalidArgumentException("Il campo '$key' deve essere una data nel formato '$format'.");
        }
        return $date;
    }

    /**
     * Recupera e valida un file caricato tramite form
     * $_FILES contiene i dati del file: nome, tipo, dimensioni, ecc.
     * UPLOAD_ERR_OK (valore 0) significa che il file è stato caricato correttamente
     */
    public static function postFile(string $key): array {
        if (!isset($_FILES[$key]) || $_FILES[$key]['error'] !== UPLOAD_ERR_OK) {
            throw new InvalidArgumentException("File '$key' non valido o non caricato.");
        }
        return $_FILES[$key];
    }

    /**
     * Recupera e valida un array inviato dal form POST
     * is_array() verifica che il valore sia un array
     * Se il campo non esiste o è vuoto, restituisce un array vuoto [] se richiesto.
     */
    public static function postArray(string $key, bool $required = false): array {
        $value = $_POST[$key] ?? [];

        if ($value === null || $value === []){
            if ($required) {
                throw new InvalidArgumentException("Il campo '$key' è richiesto.");
            }
            return [];
        }

        if (!is_array($value)) {
            throw new InvalidArgumentException("Il campo '$key' deve essere un elenco valido (array).");
        }

        return $value;
    }

    /**
     * Recupera e valida un valore booleano da una richiesta POST.
     * Gestisce stringhe come 'true', '1', 'on' e 'yes' come TRUE.
     * Se la chiave non esiste, restituisce il valore di default indicato.
     */
    public static function postBool(string $key, bool $default = false): bool {
        if (!isset($_POST[$key])) {
            return $default;
        }

        $value = $_POST[$key];

        //Se è già un booleano per qualche motivo nativo o manipolazione precedente
        if (is_bool($value)) {
            return $value;
        }

        //Filtra e converte stringhe comuni in booleani reali.
        //'true', '1', 'on' e 'yes' restituiscono true; tutto il resto false
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Verifica se la richiesta corrente è una chiamata AJAX (asincrona).
     * Controlla la presenza dell'header HTTP 'X-Requested-With', oppure il
     * Content-Type/Accept di tipo JSON (usato dalle fetch() della Presentation
     * che non impostano X-Requested-With esplicitamente).
     */
    public static function isAjax(): bool {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                return true;
        }

        if (isset($_SERVER['HTTP_ACCEPT']) &&
            str_contains(strtolower($_SERVER['HTTP_ACCEPT']), 'application/json')) {
                return true;
        }

        if (isset($_SERVER['CONTENT_TYPE']) &&
            str_contains(strtolower($_SERVER['CONTENT_TYPE']), 'application/json')) {
                return true;
        }

        return false;

    }

    /**
     * Recupera l'URL della pagina precedente (HTTP_REFERER).
     * Se non è presente o è vuoto, restituisce il valore di fallback indicato.
     * $_SERVER['HTTP_REFERER'] è una variabile globale di PHP che viene riempita automaticamente
     * dal browser e contiene l'URL della pagina web precedente
     */
    public static function getReferer(string $fallback = '/'): string {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) === false && isset($_SERVER['HTTP_REFERER'])) 
        ? $_SERVER['HTTP_REFERER'] 
        : $fallback;
    }

}