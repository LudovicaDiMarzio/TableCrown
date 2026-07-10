<?php
// Presentation/Views/ViewCatalogo.php

require_once __DIR__ . '/SmartyConfiguration.php';

class ViewCatalogo {

    /**
     * Assign comuni a tutte e 3 le pagine catalogo (giochi / bustine / portadadi).
     * Privato: viene richiamato dai metodi pubblici sotto, non dall'esterno.
     */
    private static function assignComuni(Smarty $smarty, array $dati): void {

        // --- Dati globali di layout (sempre presenti, come in ViewCarrello) ---
        $smarty->assign('base_url',     $dati['base_url']);
        $smarty->assign('current_page', $dati['current_page']);
        $smarty->assign('breadcrumbs',  $dati['breadcrumbs'] ?? []);
        $smarty->assign('utente',       $dati['utente'] ?? null);
        $smarty->assign('cart_count',   $dati['cart_count'] ?? 0);

        if (isset($dati['flash_message'])) {
            $smarty->assign('flash_message', $dati['flash_message']);
            $smarty->assign('flash_type', $dati['flash_type']);
        }

        // --- Dati comuni alle pagine catalogo ---
        $smarty->assign('prodotti',       $dati['prodotti'] ?? []);
        $smarty->assign('total_results',  $dati['total_results'] ?? 0);
        $smarty->assign('pagination',     $dati['pagination'] ?? ['current_page' => 1, 'total_pages' => 1]);
        $smarty->assign('search_query',   $dati['search_query'] ?? '');
        $smarty->assign('ordinamento',    $dati['ordinamento'] ?? 'rilevanza');

        $smarty->assign('price_min',       $dati['price_min'] ?? null);
        $smarty->assign('price_max',       $dati['price_max'] ?? null);
        $smarty->assign('price_range_min', $dati['price_range_min'] ?? 0);
        $smarty->assign('price_range_max', $dati['price_range_max'] ?? 200);

        $smarty->assign('disponibilita',       $dati['disponibilita'] ?? []);
        $smarty->assign('in_evidenza_filtro',  $dati['in_evidenza_filtro'] ?? []);
        $smarty->assign('rating_min',          $dati['rating_min'] ?? 0);
    }

    /**
     * Pagina "Giochi da tavolo": comuni + campi specifici (enum categoria/lingua/danno, ecc.)
     */
    public static function mostraGiochiDaTavolo(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        self::assignComuni($smarty, $dati);

        // --- Dati specifici di GiochiDaTavolo.tpl ---
        $smarty->assign('categorie_enum',      $dati['categorie_enum'] ?? []);
        $smarty->assign('categoria_selected',  $dati['categoria_selected'] ?? []);
        $smarty->assign('solo_base_game',      $dati['solo_base_game'] ?? false);
        $smarty->assign('solo_espansioni',     $dati['solo_espansioni'] ?? false);
        $smarty->assign('age_min',             $dati['age_min'] ?? null);
        $smarty->assign('difficolta',          $dati['difficolta'] ?? []);
        $smarty->assign('players_min',         $dati['players_min'] ?? null);
        $smarty->assign('lingue_enum',         $dati['lingue_enum'] ?? []);
        $smarty->assign('lingua',              $dati['lingua'] ?? []);
        $smarty->assign('danno_enum',          $dati['danno_enum'] ?? []);
        $smarty->assign('danno',               $dati['danno'] ?? []);

        $smarty->display('GiochiDaTavolo.tpl');
    }

    /**
     * Pagina "Bustine": solo i campi comuni.
     */
    public static function mostraBustine(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        self::assignComuni($smarty, $dati);

        $smarty->display('bustine.tpl');
    }

    /**
     * Pagina "Portadadi": solo i campi comuni.
     */
    public static function mostraPortadadi(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        self::assignComuni($smarty, $dati);

        $smarty->display('portadadi.tpl');
    }
}