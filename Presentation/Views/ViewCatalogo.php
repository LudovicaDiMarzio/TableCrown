<?php
// Presentation/Views/CatalogoView.php

require_once __DIR__ . '/../../config.php';

class ViewCatalogo {
    private $smarty;

    public function __construct($smarty) {
        $this->smarty = $smarty;
    }

    public function render(array $dati) {
        $this->smarty->assign('utente',       $dati['utente']       ?? null);
        $this->smarty->assign('prodotti',     $dati['prodotti']     ?? []);
        $this->smarty->assign('categorie',    $dati['categorie']    ?? []);
        $this->smarty->assign('filtri',       $dati['filtri']       ?? []);
        $this->smarty->assign('pagina',       $dati['pagina']       ?? 1);
        $this->smarty->assign('totale_pagine',$dati['totale_pagine']?? 1);
        $this->smarty->assign('offerte',      $dati['offerte']      ?? []);
        $this->smarty->assign('nuovi_arrivi', $dati['nuovi_arrivi'] ?? []);
        $this->smarty->assign('base_url',     BASE_URL);

        $this->smarty->display('catalogo.tpl');
    }
}