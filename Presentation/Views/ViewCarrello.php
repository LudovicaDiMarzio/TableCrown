<?php
// Presentation/Views/CarrelloView.php

require_once __DIR__ . '/../../config.php';

class ViewCarrello {
    private $smarty;

    public function __construct($smarty) {
        $this->smarty = $smarty;
    }

    public function render(array $dati) {
        $this->smarty->assign('utente',       $dati['utente']       ?? null);
        $this->smarty->assign('carrello',     $dati['carrello']     ?? []);
        $this->smarty->assign('totale',       $dati['totale']       ?? 0);
        $this->smarty->assign('offerte',      $dati['offerte']      ?? []);
        $this->smarty->assign('nuovi_arrivi', $dati['nuovi_arrivi'] ?? []);
        $this->smarty->assign('base_url',     BASE_URL);

        $this->smarty->display('carrello.tpl');
    }
}