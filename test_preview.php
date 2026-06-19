<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';

use Smarty\Smarty;
$smarty = new Smarty();

////////////////////////////////////////////////////////////////
// DATI FAKE PER catalogo_challenge.tpl
////////////////////////////////////////////////////////////////

$smarty->assign('filtri', [
    'data'  => '',
    'stato' => 'programma'
]);

$statoProgrammato = new class {
    public string $name = 'Programmato';
};

$statoTerminato = new class {
    public string $name = 'Terminato';
};

// Fake EPrezzo — senza sconto
$prezzo1 = new class {
    public function getValore(): float { return 8.00; }
    public function getValuta() { return new class { public string $name = 'EUR'; }; }
    public function getSconto(): float { return 0; }
    public function hasSconto(): bool { return false; }
    public function calcolaPrezzoScontato(): float { return 8.00; }
};

// Fake EPrezzo — con sconto 25%
$prezzo2 = new class {
    public function getValore(): float { return 12.00; }
    public function getValuta() { return new class { public string $name = 'EUR'; }; }
    public function getSconto(): float { return 25; }
    public function hasSconto(): bool { return true; }
    public function calcolaPrezzoScontato(): float { return 9.00; }
};

// Fake EChallenge #1 — in programma
$challenge1 = new class($statoProgrammato, $prezzo1) {
    private $stato, $quota;
    public function __construct($stato, $quota) {
        $this->stato = $stato;
        $this->quota = $quota;
    }
    public function getIdEvento() { return 1; }
    public function getNomeEvento() { return 'Crown Challenge Estate 2026'; }
    public function getImgEvento() { return 'placeholder.jpg'; }
    public function getDataInizio() { return new DateTime('2026-08-15 17:00:00'); }
    public function getMaxPartecipanti() { return 24; }
    public function getNumeroPartecipanti() { return 9; }
    public function getStatoEvento() { return $this->stato; }
    public function getQuotaIscrizione() { return $this->quota; }
};

// Fake EChallenge #2 — passata, con sconto
$challenge2 = new class($statoTerminato, $prezzo2) {
    private $stato, $quota;
    public function __construct($stato, $quota) {
        $this->stato = $stato;
        $this->quota = $quota;
    }
    public function getIdEvento() { return 2; }
    public function getNomeEvento() { return 'Crown Challenge Primavera 2026'; }
    public function getImgEvento() { return 'placeholder.jpg'; }
    public function getDataInizio() { return new DateTime('2026-04-05 16:00:00'); }
    public function getMaxPartecipanti() { return 20; }
    public function getNumeroPartecipanti() { return 20; }
    public function getStatoEvento() { return $this->stato; }
    public function getQuotaIscrizione() { return $this->quota; }
};

$smarty->assign('eventi', [$challenge1, $challenge2]);

////////////////////////////////////////////////////////////////

$smarty->setTemplateDir(SMARTY_DIR . 'templates/');
$smarty->setCompileDir(SMARTY_DIR  . 'templates_c/');
$smarty->setCacheDir(SMARTY_DIR    . 'cache/');
$smarty->setConfigDir(SMARTY_DIR   . 'configs/');

$smarty->assign('base_url', BASE_URL);

$smarty->display('eventi.tpl');