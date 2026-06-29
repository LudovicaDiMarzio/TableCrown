<?php
// Presentation/Views/CatalogoView.php

require_once __DIR__ . '/SmartyConfiguration.php';

class ViewCatalogo {
    public static function render(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();
        $smarty->assign('utente',        $dati['utente']        ?? null);
        $smarty->assign('prodotti',      $dati['prodotti']      ?? []);
        $smarty->assign('categorie',     $dati['categorie']     ?? []);
        $smarty->assign('filtri',        $dati['filtri']        ?? []);
        $smarty->assign('pagina',        $dati['pagina']        ?? 1);
        $smarty->assign('totale_pagine', $dati['totale_pagine'] ?? 1);
        $smarty->assign('offerte',       $dati['offerte']       ?? []);
        $smarty->assign('nuovi_arrivi',  $dati['nuovi_arrivi']  ?? []);
        $smarty->assign('base_url',      BASE_URL);
        $smarty->display('catalogo.tpl');
    }
}