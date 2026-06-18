<?php
// Presentation/Views/HomeView.php

require_once __DIR__ . '/../../config.php';

class ViewHome {
    private $smarty;

    public function __construct($smarty) {
        $this->smarty = $smarty;
    }

    public function render(array $dati) {
        $this->smarty->assign('utente',       $dati['utente']       ?? null);
        $this->smarty->assign('offerte',      $dati['offerte']      ?? []);
        $this->smarty->assign('nuovi_arrivi', $dati['nuovi_arrivi'] ?? []);
        $this->smarty->assign('in_evidenza',  $dati['in_evidenza']  ?? []);
        $this->smarty->assign('categorie',    $dati['categorie']    ?? []);
        $this->smarty->assign('base_url',     BASE_URL);

        $this->smarty->display('home.tpl');
    }
}