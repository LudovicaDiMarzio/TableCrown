<?php
// Presentation/Views/ViewModificaAccount.php

require_once __DIR__ . '/SmartyConfiguration.php';

class ViewModificaAccount {

    /**
     * Esegue gli assign per la pagina di modifica account e il display del template.
     * $dati è l'array prodotto da CModificaAccount dopo preparaDatiLayout().
     */
    public static function mostraModificaAccount(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        // --- Dati globali di layout ---
        $smarty->assign('base_url',     $dati['base_url'] ?? '');
        $smarty->assign('current_page', $dati['current_page'] ?? 'modifica-account');
        $smarty->assign('breadcrumbs',  $dati['breadcrumbs'] ?? []);
        $smarty->assign('utente',       $dati['utente'] ?? null); // solo per l'header (es. 'name')
        $smarty->assign('cart_count',   $dati['cart_count'] ?? 0);

        if (isset($dati['flash_message'])) {
            $smarty->assign('flash_message', $dati['flash_message']);
            $smarty->assign('flash_type', $dati['flash_type']);
        }

        // --- Dati specifici della pagina di modifica account ---
        // Variabili piatte separate dall'array 'utente' di layout: il form
        // legge direttamente $nomeUtente, $emailUtente, ecc. (non $utente.*).
        $smarty->assign('nomeUtente', $dati['nomeUtente'] ?? '');
        $smarty->assign('emailUtente', $dati['emailUtente'] ?? '');
        $smarty->assign('immagineUtente', $dati['immagineUtente'] ?? null);
        $smarty->assign('etaUtente', $dati['etaUtente'] ?? null);

        $smarty->display('ModificaAccount.tpl');
    }
}