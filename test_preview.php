<?php
// 1. Includi l'autoloader o il file in cui inizializzi Smarty nel tuo progetto
// require_once 'path/to/smarty/bootstrap.php'; 

// (Esempio generico di inizializzazione se non hai un file globale)
require_once 'vendor/autoload.php';
$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . '/templates');
$smarty->setCompileDir(__DIR__ . '/templates_c');

// 2. CREIAMO I DATI FINTI (MOCK) PER IL TEST
// Creiamo delle classi veloci che mimano il comportamento del tuo database/model

class MockPrezzo {
    public function hasSconto() { return true; }
    public function calcolaPrezzoScontato() { return 19.90; }
    public function getValore() { return 29.90; }
}

class MockProdotto {
    public function getIdProdotto() { return 42; }
    public function getImgProdotto() { return 'esempio-tavolo.jpg'; } // Metti un'immagine reale se l'hai nella cartella
    public function getNomeProdotto() { return 'Tavolo Impero in Noce'; }
    public function getPrezzo() { return new MockPrezzo(); }
    public function getValutazioneMedia() { return 4.5; }
}

class MockItem {
    public function getIdItem() { return 1; }
    public function getProdotto() { return new MockProdotto(); }
    public function getQuantita() { return 2; }
    public function getSubtotale() { return 39.80; } // 19.90 * 2
}

class MockCarrello {
    public function getItems() { 
        return [new MockItem()]; // Un array con un articolo dentro
    }
    public function getTotaleArticoli() { return 2; }
    public function getSconto() { return 10.00; }
    public function getSpedizione() { return 0.00; } // Gratuita
    public function getTotale() { return 39.80; }
}

// 3. ASSEGNAZIONE DELLE VARIABILI A SMARTY
$smarty->assign('carrello', new MockCarrello());
$smarty->assign('correlati', [new MockProdotto(), new MockProdotto()]); // Ne passiamo due nei correlati
$smarty->assign('base_url', '.'); // Punto di partenza per i percorsi relativi nel tuo ambiente locale

// 4. RENDERING DEL TEMPLATE
$smarty->display('carrello.tpl');