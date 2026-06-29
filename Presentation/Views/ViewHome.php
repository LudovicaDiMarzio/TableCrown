<?php
// Presentation/Views/HomeView.php

require_once __DIR__ . '/SmartyConfiguration.php';

class ViewHome {
    public static function render(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();
        $smarty->assign('utente',      $dati['utente']      ?? null);
        $smarty->assign('offerte',     $dati['offerte']     ?? []);
        $smarty->assign('nuovi_arrivi',$dati['nuovi_arrivi']?? []);
        $smarty->assign('in_evidenza', $dati['in_evidenza'] ?? []);
        $smarty->assign('categorie',   $dati['categorie']   ?? []);
        $smarty->assign('base_url',    BASE_URL);
        $smarty->display('home.tpl');
    }
}