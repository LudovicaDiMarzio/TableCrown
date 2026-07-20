<?php
// Presentation/Views/ViewProfiloBase.php

namespace TableCrown\Presentation\Views;

use SmartyConfiguration;
use Smarty\Smarty;

abstract class ViewProfiloBase {

    /**
     * Assegna le variabili globali di layout comuni a tutte le pagine profilo.
     * Ogni View chiama questo come primo passo, passando lo Smarty e i $dati ricevuti.
     */
    protected static function assegnaGlobali(Smarty $smarty, array $dati, string $currentPageDefault): void {
        $smarty->assign('base_url',     $dati['base_url'] ?? '');
        $smarty->assign('current_page', $dati['current_page'] ?? $currentPageDefault);
        $smarty->assign('breadcrumbs',  $dati['breadcrumbs'] ?? []);
        $smarty->assign('utente',       $dati['utente'] ?? null);
        $smarty->assign('cart_count',   $dati['cart_count'] ?? 0);

        if (isset($dati['flash_message'])) {
            $smarty->assign('flash_message', $dati['flash_message']);
            $smarty->assign('flash_type', $dati['flash_type']);
        }
    }
}