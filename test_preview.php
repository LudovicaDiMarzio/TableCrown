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

$smarty->clearAllCache();
$smarty->clearCompiledTemplate();

// Definiamo i dati di base per l'header e i link
$smarty->assign('page_title', 'TableCrown — Home');
$smarty->assign('base_url', 'http://localhost:8000'); // Modifica se la cartella public ha un percorso diverso

// NOTA: Se hai lasciato i vettori vuoti o non settati, home.tpl mostrerà automaticamente 
// i 4 prodotti demo statici grazie al blocco {else} che abbiamo strutturato insieme.
$smarty->assign('offerte', []); 
$smarty->assign('nuovi_arrivi', []); 


// ── MOCK PRODOTTO ──
$mockPrezzo = new class {
    public function hasSconto(): bool { return true; }
    public function getSconto(): int { return 20; }
    public function getValore(): float { return 49.90; }
    public function calcolaPrezzoScontato(): float { return 39.92; }
};

$mockProdotto = new class($mockPrezzo) {
    private $prezzo;
    public function __construct($prezzo) { $this->prezzo = $prezzo; }
    public function getIdProdotto(): int { return 1; }
    public function getNomeProdotto(): string { return 'Catan'; }
    public function getImgProdotto(): string { return 'placeholder.jpg'; }
    public function getImmagini(): array { return ['placeholder.jpg']; }
    public function getDisponibilitaProdotto(): string { return 'In arrivo'; }
    public function getValutazioneMedia(): float { return 4.5; }
    public function getPrezzo() { return $this->prezzo; }
    public function getDescrizione(): string { return 'Un classico gioco di strategia per tutta la famiglia.'; }
    public function getComponenti(): array { return ['19 tessere territorio', '95 risorse', '60 strade', '2 dadi']; }
    public function getGiocatoriMin(): int { return 3; }
    public function getGiocatoriMax(): int { return 4; }
    public function getEtaMin(): int { return 10; }
    public function getDurata(): int { return 90; }
    public function getDifficolta(): string { return 'Media'; }
    public function getLingua(): string { return 'Italiano'; }
};

$mockRecensione = new class {
    public function getNicknameUtente(): string { return 'GiocatoreTop'; }
    public function getVoto(): int { return 5; }
    public function getTitolo(): string { return 'Gioco fantastico!'; }
    public function getTesto(): string { return 'Lo consiglio a tutti, ore di divertimento garantite.' ; }
};

// ── MOCK ORDINE ITEM ──
$mockOrdineItem = new class($mockProdotto) {
    private $prodotto;
    public function __construct($prodotto) { $this->prodotto = $prodotto; }
    public function getProdotto() { return $this->prodotto; }
};

// ── MOCK ORDINE ──
$mockOrdineConProdotto = new class($mockOrdineItem) {
    private $ordineItem;
    public function __construct($ordineItem) { $this->ordineItem = $ordineItem; }
    public function getOrdineItems() { return [$this->ordineItem]; }
};

// ── SCENARIO 1: Utente CON ACQUISTO (mostra form) ──
$mockUtenteConAcquisto = new class($mockOrdineConProdotto, $mockProdotto) {
    private $ordini;
    private $prodotto;
    
    public function __construct($ordine, $prodotto) {
        $this->ordini = [$ordine];
        $this->prodotto = $prodotto;
    }
    
    public function getNickname(): string { return 'GiocatoreTop'; }
    
    public function hasPurchasedProduct($prodotto): bool {
        foreach ($this->ordini as $ordine) {
            foreach ($ordine->getOrdineItems() as $item) {
                if ($item->getProdotto()->getIdProdotto() === $prodotto->getIdProdotto()) {
                    return true;
                }
            }
        }
        return false;
    }
};

// ── SCENARIO 2: Utente SENZA ACQUISTO (mostra blocco) ──
$mockUtenteSenzaAcquisto = new class {
    public function getNickname(): string { return 'NuovoUtente'; }
    
    public function hasPurchasedProduct($prodotto): bool {
        return false; // Non ha comprato nulla
    }
};

// ────────────────────────────────────────────────────
// 🔧 SCEGLI QUI QUALE SCENARIO TESTARE
// ────────────────────────────────────────────────────

// ✅ Decommenta per testare UTENTE CON ACQUISTO
//$utenteDaTestare = new $mockUtenteConAcquisto($mockOrdineConProdotto, $mockProdotto);
//$userHasPurchased = $utenteDaTestare->hasPurchasedProduct($mockProdotto);

// ❌ Commenta la riga sopra e decomenta questa per testare SENZA ACQUISTO
 $utenteDaTestare = new $mockUtenteSenzaAcquisto();
 $userHasPurchased = $utenteDaTestare->hasPurchasedProduct($mockProdotto);

// ── Assegna al template ──
$smarty->assign('utente', $utenteDaTestare);
$smarty->assign('userHasPurchased', $userHasPurchased);  // ← NUOVA VARIABILE!
$smarty->assign('prodotto', $mockProdotto);
$smarty->assign('recensioni', [$mockRecensione]);
$smarty->assign('correlati', []);



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

