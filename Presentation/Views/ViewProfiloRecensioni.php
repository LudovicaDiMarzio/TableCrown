<?php
// Presentation/Views/ViewProfiloRecensioni.php

require_once __DIR__ . '/SmartyConfiguration.php';

class ViewProfiloRecensioni {

    public static function mostraProfiloRecensioni(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        // --- Dati globali di layout ---
        $smarty->assign('base_url',     $dati['base_url'] ?? '');
        $smarty->assign('current_page', $dati['current_page'] ?? 'profilo-recensioni');
        $smarty->assign('breadcrumbs',  $dati['breadcrumbs'] ?? []);
        $smarty->assign('utente',       $dati['utente'] ?? null);
        $smarty->assign('cart_count',   $dati['cart_count'] ?? 0);

        if (isset($dati['flash_message'])) {
            $smarty->assign('flash_message', $dati['flash_message']);
            $smarty->assign('flash_type', $dati['flash_type']);
        }

        // --- Dati specifici della pagina recensioni ---
        // 'recensioni' con: id, valutazione, testo, data, prodotto{id,nome,immagine}, isSegnalata
        $smarty->assign('recensioni', $dati['recensioni'] ?? []);

        $smarty->display('ProfiloRecensioni.tpl');
    }
}