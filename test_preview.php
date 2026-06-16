<?php
require_once __DIR__ . '/vendor/autoload.php'; 

use Smarty\Smarty;
$smarty = new Smarty();

// 1. Ricerca automatica della cartella dei template
$possibiliPercorsi = [
    __DIR__ . '/smarty-dir/',
    __DIR__ . '/Presentation/smarty-dir/',
    __DIR__ . '/Presentation/Views/smarty-dir/',
    __DIR__ . '/presentation/smarty-dir/'
];

$smartyDirHandler = null;

foreach ($possibiliPercorsi as $percorso) {
    if (is_dir($percorso . 'templates/')) {
        $smartyDirHandler = $percorso;
        break;
    }
}

if (!$smartyDirHandler) {
    echo "<strong style='color:red;'>Impossibile trovare la cartella dei template!</strong><br>";
    echo "Assicurati che la cartella <code>templates</code> sia dentro <code>smarty-dir</code>.";
    exit;
}

// 2. Configurazione dei percorsi di Smarty
$smarty->setTemplateDir($smartyDirHandler . 'templates/');
$smarty->setCompileDir($smartyDirHandler . 'templates_c/');
$smarty->setCacheDir($smartyDirHandler . 'cache/');
$smarty->setConfigDir($smartyDirHandler . 'configs/');

// Definiamo i dati di base per l'header e i link
$smarty->assign('page_title', 'TableCrown — Home');
$smarty->assign('base_url', '/public'); // Modifica se la cartella public ha un percorso diverso

// NOTA: Se hai lasciato i vettori vuoti o non settati, home.tpl mostrerà automaticamente 
// i 4 prodotti demo statici grazie al blocco {else} che abbiamo strutturato insieme.
$smarty->assign('offerte', []); 
$smarty->assign('nuovi_arrivi', []); 

// 3. Tentativo di rendering della HOME
try {
    // MODIFICATO: Puntiamo alla home.tpl. 
    // Se hai salvato home.tpl nella radice di 'templates/', usa semplicemente 'home.tpl'.
    // Se l'hai messa in una sottocartella (es. 'pages/home.tpl'), modifica il percorso di conseguenza.
    $smarty->display('prodotto.tpl'); 
    
} catch (Exception $e) {
    echo "<strong style='color:orange;'>Errore nel caricamento della Home:</strong><br>";
    echo "<i>" . $e->getMessage() . "</i><br><br>";
    echo "<strong>Verifica:</strong> Assicurati di aver salvato il file <code>home.tpl</code> dentro la cartella: <code>" . htmlspecialchars($smartyDirHandler) . "templates/</code>";
}

class FakePrezzo {
    public function hasSconto() { return true; }
    public function calcolaPrezzoScontato() { return 19.99; }
    public function getValore() { return 24.99; }
    public function getSconto() { return 20; }
}

class FakeProdotto {
    public function getNomeProdotto() { return "Gioco di Ruolo di Test"; }
    public function getImmagini() { return ['img1.jpg', 'img2.jpg']; }
    public function getImgProdotto() { return 'img1.jpg'; }
    public function getDisponibilitaProdotto() { return 'disponibile'; }
    public function getValutazioneMedia() { return 4.5; }
    public function getGiocatoriMin() { return 2; }
    public function getGiocatoriMax() { return 5; }
    public function getEtaMin() { return 12; }
    public function getDurata() { return 60; }
    public function getDifficolta() { return "Media"; }
    public function getLingua() { return "Italiano"; }
    public function getPrezzo() { return new FakePrezzo(); }
    public function getDescrizione() { return "Una descrizione di prova molto bella."; }
    public function getComponenti() { return ["100 Carte", "1 Tabellone", "Dadi"]; }
    public function getIdProdotto() { return 1; }
}

// Passalo a Smarty
$smarty->assign('prodotto', new FakeProdotto());
$smarty->assign('correlati', []); // array vuoto per ora
$smarty->assign('utente_loggato', true);

$smarty->display('prodotto.tpl');