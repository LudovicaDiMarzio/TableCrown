<?php
// 1. Includi l'autoloader di Composer
require_once __DIR__ . '/vendor/autoload.php'; 

// NOTA IL CAMBIAMENTO QUI: Usiamo il namespace corretto di Smarty 5
$smarty = new \Smarty\Smarty();

$smarty->setTemplateDir(__DIR__ . '/templates');
$smarty->setCompileDir(__DIR__ . '/templates_c');

// 2. CREIAMO I DATI FINTI (MOCK) PER IL TEST
class MockPrezzo {
    public function hasSconto() { return true; }
    public function calcolaPrezzoScontato() { return 19.90; }
    public function getValore() { return 29.90; }
}

class MockProdotto {
    public function getIdProdotto() { return 42; }
    public function getImgProdotto() { return 'esempio-tavolo.jpg'; } 
    public function getNomeProdotto() { return 'Tavolo Impero in Noce'; }
    public function getPrezzo() { return new MockPrezzo(); }
    public function getValutazioneMedia() { return 4.5; }
}

class MockItem {
    public function getIdItem() { return 1; }
    public function getProdotto() { return new MockProdotto(); }
    public function getQuantita() { return 2; }
    public function getSubtotale() { return 39.80; } 
}

class MockCarrello {
    public function getItems() { 
        return [new MockItem()]; 
    }
    public function getTotaleArticoli() { return 2; }
    public function getSconto() { return 10.00; }
    public function getSpedizione() { return 0.00; } 
    public function getTotale() { return 39.80; }
}

// 3. ASSEGNAZIONE DELLE VARIABILI A SMARTY
$smarty->assign('carrello', new MockCarrello());
$smarty->assign('correlati', [new MockProdotto(), new MockProdotto()]); 
$smarty->assign('base_url', '.'); 

// 4. RENDERING DEL TEMPLATE
$smarty->display('templates/carrello.tpl');