<?php
// Presentation/Views/ProdottoView.php

require_once __DIR__ . '/SmartyConfiguration.php';

class ViewProdotto {
    public static function render(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();
        $smarty->assign('prodotto',         $dati['prodotto']);
        $smarty->assign('recensioni',       $dati['recensioni']       ?? []);
        $smarty->assign('correlati',        $dati['correlati']        ?? []);
        $smarty->assign('utente',           $dati['utente']           ?? null);
        $smarty->assign('userHasPurchased', $dati['userHasPurchased'] ?? false);
        $smarty->assign('offerte',          $dati['offerte']          ?? []);
        $smarty->assign('nuovi_arrivi',     $dati['nuovi_arrivi']     ?? []);
        $smarty->assign('base_url',         BASE_URL);
        $smarty->display('prodotto.tpl');
    }
}