<?php
// Presentation/Views/ViewHome.php

require_once __DIR__ . '/SmartyConfiguration.php';

class ViewHome {

    /**
     * Esegue gli assign per la homepage e il display del template.
     * $dati è l'array prodotto da CNavigazione::mostraHome() dopo preparaDatiLayout().
     */
    public static function mostraHome(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        // --- Dati globali di layout (sempre presenti) ---
        $smarty->assign('base_url',     $dati['base_url']);
        $smarty->assign('current_page', $dati['current_page']);
        $smarty->assign('breadcrumbs',  $dati['breadcrumbs'] ?? []);
        $smarty->assign('utente',       $dati['utente'] ?? null);
        $smarty->assign('cart_count',   $dati['cart_count'] ?? 0);

        if (isset($dati['flash_message'])) {
            $smarty->assign('flash_message', $dati['flash_message']);
            $smarty->assign('flash_type', $dati['flash_type']);
        }

        // --- Dati specifici della homepage ---
        $smarty->assign('offerte',      $dati['offerte'] ?? []);
        $smarty->assign('nuovi_arrivi', $dati['nuovi_arrivi'] ?? []);

    

        $smarty->display('home.tpl');
    }
}