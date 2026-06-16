<?php
require_once __DIR__ . '/vendor/autoload.php'; 

use Smarty\Smarty;
$smarty = new Smarty();

// ════════════════════════════════════════════════════════════
// CLASSI MOCK PER I DATI
// ════════════════════════════════════════════════════════════

class Prezzo {
    private $valore;
    private $sconto;
    private $percentuale;

    public function __construct($valore, $sconto = 0, $percentuale = 0) {
        $this->valore = $valore;
        $this->sconto = $sconto;
        $this->percentuale = $percentuale;
    }

    public function getValore() {
        return $this->valore;
    }

    public function hasSconto() {
        return $this->sconto > 0;
    }

    public function calcolaPrezzoScontato() {
        return $this->valore - $this->sconto;
    }

    public function getPercentualeSconto() {
        return $this->percentuale;
    }
}

class Prodotto {
    private $id;
    private $nome;
    private $immagine;
    private $disponibilita;
    private $prezzo;
    private $valutazione;

    public function __construct($id, $nome, $immagine, $disponibilita, $prezzo, $valutazione) {
        $this->id = $id;
        $this->nome = $nome;
        $this->immagine = $immagine;
        $this->disponibilita = $disponibilita;
        $this->prezzo = $prezzo;
        $this->valutazione = $valutazione;
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getImmagine() {
        return $this->immagine;
    }

    public function getDisponibilita() {
        return $this->disponibilita;
    }

    public function getPrezzo() {
        return $this->prezzo;
    }

    public function getValutazioneMedia() {
        return $this->valutazione;
    }
}

class Categoria {
    private $id;
    private $nome;

    public function __construct($id, $nome) {
        $this->id = $id;
        $this->nome = $nome;
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }
}

// ════════════════════════════════════════════════════════════
// CONFIGURAZIONE SMARTY
// ════════════════════════════════════════════════════════════

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

$smarty->setTemplateDir($smartyDirHandler . 'templates/');
$smarty->setCompileDir($smartyDirHandler . 'templates_c/');
$smarty->setCacheDir($smartyDirHandler . 'cache/');
$smarty->setConfigDir($smartyDirHandler . 'configs/');

$smarty->assign('base_url', '/public');

// ════════════════════════════════════════════════════════════
// DATI DI TEST - PRODOTTI
// ════════════════════════════════════════════════════════════

$prodotti = [
    new Prodotto(
        1,
        'Catan - I Coloni di Catan',
        'catan.jpg',
        'disponibile',
        new Prezzo(35.00, 5.00, 15),
        4.5
    ),
    new Prodotto(
        2,
        'Ticket to Ride',
        'ticket-to-ride.jpg',
        'disponibile',
        new Prezzo(42.50, 0, 0),
        4.8
    ),
    new Prodotto(
        3,
        'Carcassonne',
        'carcassonne.jpg',
        'esaurito',
        new Prezzo(28.00, 0, 0),
        4.2
    ),
    new Prodotto(
        4,
        'Splendor',
        'splendor.jpg',
        'annunciato',
        new Prezzo(40.00, 8.00, 20),
        4.6
    ),
    new Prodotto(
        5,
        'Agricola',
        'agricola.jpg',
        'disponibile',
        new Prezzo(45.00, 0, 0),
        4.7
    ),
    new Prodotto(
        6,
        'Puerto Rico',
        'puerto-rico.jpg',
        'disponibile',
        new Prezzo(50.00, 10.00, 20),
        4.4
    ),
    new Prodotto(
        7,
        'Dominion',
        'dominion.jpg',
        'disponibile',
        new Prezzo(38.00, 3.00, 8),
        4.3
    ),
    new Prodotto(
        8,
        'Pandemic',
        'pandemic.jpg',
        'disponibile',
        new Prezzo(35.50, 0, 0),
        4.5
    ),
];

$categorie = [
    new Categoria(1, 'Strategia'),
    new Categoria(2, 'Famiglia'),
    new Categoria(3, 'Party Games'),
    new Categoria(4, 'Cooperativi'),
    new Categoria(5, 'Astratti'),
];

// ════════════════════════════════════════════════════════════
// ASSEGNAZIONE DATI A SMARTY
// ════════════════════════════════════════════════════════════

$smarty->assign('prodotti', $prodotti);
$smarty->assign('categorie', $categorie);
$smarty->assign('total_results', count($prodotti));
$smarty->assign('page_title', 'TableCrown — Catalogo');

// Dati di ricerca/filtri (vuoti per il test)
$smarty->assign('search_query', '');
$smarty->assign('ordinamento', 'rilevanza');
$smarty->assign('price_min', '');
$smarty->assign('price_max', '');
$smarty->assign('disponibilita', []);
$smarty->assign('offerte', []);
$smarty->assign('categoria_selected', []);
$smarty->assign('espansioni', '');
$smarty->assign('rating_min', 0);
$smarty->assign('age_min', '');
$smarty->assign('age_max', '');
$smarty->assign('players_min', '');
$smarty->assign('players_max', '');
$smarty->assign('lingua', '');
$smarty->assign('difficolta', '');

// Paginazione
$smarty->assign('pagination', [
    'current_page' => 1,
    'total_pages' => 1
]);

// ════════════════════════════════════════════════════════════
// RENDERING
// ════════════════════════════════════════════════════════════

try {
    $smarty->display('catalogo.tpl');
} catch (Exception $e) {
    echo "<strong style='color:orange;'>Errore nel caricamento del Catalogo:</strong><br>";
    echo "<i>" . $e->getMessage() . "</i><br><br>";
    echo "<strong>Verifica:</strong> Assicurati di aver salvato il file <code>catalogo.tpl</code> dentro la cartella: <code>" . htmlspecialchars($smartyDirHandler) . "templates/</code>";
}