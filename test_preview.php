<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';

use Smarty\Smarty;
$smarty = new Smarty();

$offerte = [
    ['id' => 101, 'nome' => 'Catan',       'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.5, 'prezzo' => 34.90, 'sconto' => true,  'prezzo_scontato' => 27.92],
    ['id' => 102, 'nome' => 'Carcassonne', 'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.0, 'prezzo' => 29.90, 'sconto' => true,  'prezzo_scontato' => 25.42],
    ['id' => 103, 'nome' => '7 Wonders',   'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.7, 'prezzo' => 39.90, 'sconto' => false, 'prezzo_scontato' => null],
];

$nuovi_arrivi = [
    ['id' => 201, 'nome' => 'Wingspan',         'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.8, 'prezzo' => 49.90, 'sconto' => false, 'prezzo_scontato' => null],
    ['id' => 202, 'nome' => 'Azul',             'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.6, 'prezzo' => 32.90, 'sconto' => true,  'prezzo_scontato' => 29.61],
    ['id' => 203, 'nome' => 'Brass Birmingham', 'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.9, 'prezzo' => 59.90, 'sconto' => false, 'prezzo_scontato' => null],
];


// ── PRODOTTI CATALOGO ──
$prodotti = [
    ['id' => 101, 'nome' => 'Catan',            'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.5, 'disponibilita' => 'disponibile', 'prezzo' => 34.90, 'sconto' => true,  'percentuale_sconto' => 20, 'prezzo_scontato' => 27.92],
    ['id' => 102, 'nome' => 'Carcassonne',       'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.0, 'disponibilita' => 'disponibile', 'prezzo' => 29.90, 'sconto' => true,  'percentuale_sconto' => 15, 'prezzo_scontato' => 25.42],
    ['id' => 103, 'nome' => '7 Wonders',         'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.7, 'disponibilita' => 'esaurito',    'prezzo' => 39.90, 'sconto' => false, 'percentuale_sconto' => null, 'prezzo_scontato' => null],
    ['id' => 201, 'nome' => 'Wingspan',          'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.8, 'disponibilita' => 'disponibile', 'prezzo' => 49.90, 'sconto' => false, 'percentuale_sconto' => null, 'prezzo_scontato' => null],
    ['id' => 202, 'nome' => 'Azul',              'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.6, 'disponibilita' => 'disponibile', 'prezzo' => 32.90, 'sconto' => true,  'percentuale_sconto' => 10, 'prezzo_scontato' => 29.61],
    ['id' => 203, 'nome' => 'Brass Birmingham',  'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.9, 'disponibilita' => 'annunciato',  'prezzo' => 59.90, 'sconto' => false, 'percentuale_sconto' => null, 'prezzo_scontato' => null],
];

// ── CATEGORIE ──
$categorie = [
    ['id' => 1, 'nome' => 'Strategia'],
    ['id' => 2, 'nome' => 'Famiglia'],
    ['id' => 3, 'nome' => 'Cooperativo'],
    ['id' => 4, 'nome' => 'Carte'],
];

// ── PAGINAZIONE ──
$pagination = [
    'current_page' => 1,
    'total_pages'  => 3,
];

$carrello_items = [
    [
        'id_item'          => 1,
        'quantita'         => 2,
        'prezzo_unitario'  => 27.92,
        'subtotale'        => 55.84,
        'sconto'           => true,
        'prezzo_originale' => 34.90,
        'prodotto' => [
            'id'      => 101,
            'nome'    => 'Catan',
            'immagine'=> 'placeholder.jpg',
        ],
        'update_url' => '/carrello/aggiorna/1',
    ],
    [
        'id_item'          => 2,
        'quantita'         => 1,
        'prezzo_unitario'  => 49.90,
        'subtotale'        => 49.90,
        'sconto'           => false,
        'prezzo_originale' => null,
        'prodotto' => [
            'id'      => 201,
            'nome'    => 'Wingspan',
            'immagine'=> 'placeholder.jpg',
        ],
        'update_url' => '/carrello/aggiorna/2',
    ],
];

$carrello_summary = [
    'n_articoli' => 3,
    'sconto'     => 6.98,
    'spedizione' => null,   // null = "Da calcolare", 0 = gratuita, float = valore
    'totale'     => 98.76,
];

$correlati = [
    ['id' => 202, 'nome' => 'Azul',             'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.6, 'sconto' => true,  'prezzo' => 32.90, 'prezzo_scontato' => 29.61],
    ['id' => 203, 'nome' => 'Brass Birmingham', 'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.9, 'sconto' => false, 'prezzo' => 59.90, 'prezzo_scontato' => null],
    ['id' => 102, 'nome' => 'Carcassonne',      'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.0, 'sconto' => true,  'prezzo' => 29.90, 'prezzo_scontato' => 25.42],
    ['id' => 103, 'nome' => '7 Wonders',        'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.7, 'sconto' => false, 'prezzo' => 39.90, 'prezzo_scontato' => null],
];


// ── PRODOTTO SINGOLO ──
$prodotto = [
    'id'            => 101,
    'nome'          => 'Catan',
    'immagine'      => 'placeholder.jpg',
    'immagini'      => ['placeholder.jpg', 'placeholder.jpg'],
    'disponibilita' => 'disponibile',
    'valutazione_media' => 4.5,
    'giocatori_min' => 3,
    'giocatori_max' => 4,
    'eta_min'       => 10,
    'durata'        => 90,
    'difficolta'    => 'Media',
    'lingua'        => 'Italiano',
    'descrizione'   => "Catan è un gioco da tavolo di strategia per 3-4 giocatori.\nRaccogli risorse, costruisci strade e insediamenti, e diventa il dominatore dell'isola.",
    'componenti'    => ['95 carte risorse', '60 tessere territorio', '2 dadi', '4 schede giocatore', '1 dado eventi'],
    'sconto'        => true,
    'percentuale_sconto' => 20,
    'prezzo'        => 34.90,
    'prezzo_scontato' => 27.92,
];

// ── RECENSIONI ──
$recensioni = [
    [
        'nickname' => 'Marco92',
        'voto'     => 5,
        'titolo'   => 'Gioco fantastico!',
        'testo'    => "Lo gioco da anni con la mia famiglia, non ci stanchiamo mai.\nConsigliato a tutti!",
    ],
    [
        'nickname' => 'GiulyGamer',
        'voto'     => 4,
        'titolo'   => 'Ottimo ma un po\' lungo',
        'testo'    => 'Bellissimo gioco strategico, forse un po\' lungo per i bambini piccoli.',
    ],
];




$smarty->setTemplateDir(SMARTY_DIR . 'templates/');
$smarty->setCompileDir(SMARTY_DIR  . 'templates_c/');
$smarty->setCacheDir(SMARTY_DIR    . 'cache/');
$smarty->setConfigDir(SMARTY_DIR   . 'configs/');

$smarty->assign('base_url',       BASE_URL);
$smarty->assign('utente',         isset($_SESSION['utente_id']) ? ['nickname' => $_SESSION['utente_nickname']] : null);
$smarty->assign('current_page',   'catalogo');
$smarty->assign('prodotti',       $prodotti);
$smarty->assign('categorie',      $categorie);
$smarty->assign('pagination',     $pagination);
$smarty->assign('total_results',  count($prodotti));
$smarty->assign('search_query',   '');
$smarty->assign('ordinamento',    'rilevanza');

$smarty->assign('carrello_items',   $carrello_items);
$smarty->assign('carrello_summary', $carrello_summary);
$smarty->assign('correlati',        $correlati);

$smarty->assign('prodotto',          $prodotto);
$smarty->assign('recensioni',        $recensioni);
$smarty->assign('userHasPurchased',  true);




$smarty->assign('base_url',     BASE_URL);
$smarty->assign('offerte',      $offerte);
$smarty->assign('nuovi_arrivi', $nuovi_arrivi);
$smarty->assign('utente', isset($_SESSION['utente_id']) ? ['nickname' => $_SESSION['utente_nickname']] : null);




$smarty->display('prodotto.tpl');