<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';

use Smarty\Smarty;
$smarty = new Smarty();

////////////////////////////////////////////////////////////////

$prezzoFake = new class {
    public function hasSconto() { return true; }
    public function getSconto() { return 20; }
    public function getValore() { return 49.90; }
    public function calcolaPrezzoScontato() { return 39.92; }
};

$prodottoFake = new class($prezzoFake) {
    private $prezzo;
    public function __construct($prezzo) { $this->prezzo = $prezzo; }
    public function getIdProdotto() { return 1; }
    public function getNomeProdotto() { return 'Catan'; }
    public function getImgProdotto() { return 'placeholder.jpg'; }
    public function getImmagini() { return []; }
    public function getDisponibilitaProdotto() { return 'disponibile'; }
    public function getValutazioneMedia() { return 4; }
    public function getPrezzo() { return $this->prezzo; }
    public function getGiocatoriMin() { return 2; }
    public function getGiocatoriMax() { return 6; }
    public function getEtaMin() { return 10; }
    public function getDurata() { return 90; }
    public function getDifficolta() { return 'Media'; }
    public function getLingua() { return 'Italiano'; }
    public function getDescrizione() { return 'Un gioco di strategia ambientato sull\'isola di Catan.'; }
    public function getComponenti() { return ['19 tessere territorio', '6 tessere mare', '9 tessere porto']; }
};

$utenteFake = new class {
    public function getNickname() { return 'cazzegio'; }
    public function getEmail() { return 'cazzegio@tablecrown.it'; }
    public function getId() { return 1; }
};

$smarty->assign('utente', $utenteFake);
$smarty->assign('userHasPurchased', true); // true = mostra form recensione

$smarty->assign('prodotto', $prodottoFake);
$smarty->assign('correlati', []);
$smarty->assign('recensioni', []);

////////////////////////////////////////////////////////////////

$smarty->setTemplateDir(SMARTY_DIR . 'templates/');
$smarty->setCompileDir(SMARTY_DIR  . 'templates_c/');
$smarty->setCacheDir(SMARTY_DIR    . 'cache/');
$smarty->setConfigDir(SMARTY_DIR   . 'configs/');

$smarty->assign('base_url', BASE_URL);
$smarty->assign('offerte', []);
$smarty->assign('nuovi_arrivi', []);

$smarty->display('eventi.tpl');