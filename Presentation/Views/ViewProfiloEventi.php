<?php
// Presentation/Views/ViewProfiloEventi.php

namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

class ViewProfiloEventi {

    public static function mostraProfiloEventi(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        // --- Dati globali di layout ---
        $smarty->assign('base_url',     $dati['base_url'] ?? '');
        $smarty->assign('current_page', $dati['current_page'] ?? 'profilo-eventi');
        $smarty->assign('breadcrumbs',  $dati['breadcrumbs'] ?? []);
        $smarty->assign('utente',       $dati['utente'] ?? null);
        $smarty->assign('cart_count',   $dati['cart_count'] ?? 0);

        if (isset($dati['flash_message'])) {
            $smarty->assign('flash_message', $dati['flash_message']);
            $smarty->assign('flash_type', $dati['flash_type']);
        }

        // --- Dati specifici della pagina eventi ---
        $smarty->assign('eventi', $dati['eventi'] ?? []);
        $smarty->assign('ordinamento', $dati['ordinamento'] ?? 'futuri');

        $smarty->display('ProfiloEventi.tpl');
    }
}