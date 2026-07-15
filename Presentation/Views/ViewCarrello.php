<?php
// Presentation/Views/ViewCarrello.php

namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

class ViewCarrello {

    /**
     * Esegue gli assign per la pagina carrello e il display del template.
     * $dati è l'array prodotto da CCarrello::mostraCarrello() dopo preparaDatiLayout().
     */
    public static function mostraCarrello(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        // --- Dati globali di layout (sempre presenti) ---
        $smarty->assign('base_url',     $dati['base_url']);
        $smarty->assign('current_page', $dati['current_page']);
        $smarty->assign('breadcrumbs',  $dati['breadcrumbs'] ?? []);
        $smarty->assign('utente',       $dati['utente'] ?? null);

        // cart_count è opzionale: presente solo se l'utente è loggato e ha articoli nel carrello
        $smarty->assign('cart_count', $dati['cart_count'] ?? 0);

        // Flash message: opzionale, assegnato solo se presente
        if (isset($dati['flash_message'])) {
            $smarty->assign('flash_message', $dati['flash_message']);
            $smarty->assign('flash_type', $dati['flash_type']);
        }

        // --- Dati specifici della pagina carrello ---
        $smarty->assign('carrello_items',   $dati['carrello_items'] ?? []);
        $smarty->assign('carrello_summary', $dati['carrello_summary'] ?? [
            'n_articoli' => 0,
            'sconto'     => 0,
            'totale'     => 0,
        ]);
        $smarty->assign('correlati', $dati['correlati'] ?? []);

        $smarty->display('carrello.tpl');
    }
}