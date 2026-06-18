<?php
// Presentation/Views/ProdottoView.php

require_once __DIR__ . '/../../config.php';

class ViewProdotto {
    private $smarty;

    public function __construct($smarty) {
        $this->smarty = $smarty;
    }

    public function render(array $dati) {
        $this->smarty->assign('prodotto',          $dati['prodotto']);
        $this->smarty->assign('recensioni',        $dati['recensioni']        ?? []);
        $this->smarty->assign('correlati',         $dati['correlati']         ?? []);
        $this->smarty->assign('utente',            $dati['utente']            ?? null);
        $this->smarty->assign('userHasPurchased',  $dati['userHasPurchased']  ?? false);
        $this->smarty->assign('offerte',           $dati['offerte']           ?? []);
        $this->smarty->assign('nuovi_arrivi',      $dati['nuovi_arrivi']      ?? []);
        $this->smarty->assign('base_url',          BASE_URL);

        $this->smarty->display('prodotto.tpl');
    }
}