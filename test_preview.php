<?php
require_once __DIR__ . '/config.php';



require_once __DIR__ . '/vendor/autoload.php';



use Smarty\Smarty;
$smarty = new Smarty();
$smarty->setTemplateDir(SMARTY_DIR . 'templates/');
$smarty->setCompileDir(SMARTY_DIR  . 'templates_c/');
$smarty->setCacheDir(SMARTY_DIR    . 'cache/');
$smarty->setConfigDir(SMARTY_DIR   . 'configs/');





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
    ['id' => 101, 'nome' => 'Catan',            'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.5, 'disponibilita' => 'disponibile', 'prezzo' => 34.90, 'sconto' => true,  'percentuale_sconto' => 20, 'prezzo_scontato' => 27.92,
        'categoria' => 'strategia', 'lingue' => 'IT,EN', 'danno' => '', 'eta_min' => 10, 'difficolta' => 'media', 'giocatori_min' => 3, 'giocatori_max' => 4, 'is_espansione' => false, 'novita' => false, 'in_top_venduti' => true, 'numero_vendite' => 340, 'data_inserimento' => '2024-03-10'],

    ['id' => 102, 'nome' => 'Carcassonne',       'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.0, 'disponibilita' => 'disponibile', 'prezzo' => 29.90, 'sconto' => true,  'percentuale_sconto' => 15, 'prezzo_scontato' => 25.42,
        'categoria' => 'famiglia', 'lingue' => 'IT', 'danno' => '', 'eta_min' => 7, 'difficolta' => 'facile', 'giocatori_min' => 2, 'giocatori_max' => 5, 'is_espansione' => false, 'novita' => false, 'in_top_venduti' => false, 'numero_vendite' => 210, 'data_inserimento' => '2024-01-05'],

    ['id' => 103, 'nome' => '7 Wonders',         'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.7, 'disponibilita' => 'esaurito',    'prezzo' => 39.90, 'sconto' => false, 'percentuale_sconto' => null, 'prezzo_scontato' => null,
        'categoria' => 'strategia', 'lingue' => 'IT,EN,FR', 'danno' => '', 'eta_min' => 10, 'difficolta' => 'media', 'giocatori_min' => 3, 'giocatori_max' => 7, 'is_espansione' => false, 'novita' => false, 'in_top_venduti' => true, 'numero_vendite' => 275, 'data_inserimento' => '2023-11-20'],

    ['id' => 201, 'nome' => 'Wingspan',          'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.8, 'disponibilita' => 'disponibile', 'prezzo' => 49.90, 'sconto' => false, 'percentuale_sconto' => null, 'prezzo_scontato' => null,
        'categoria' => 'famiglia', 'lingue' => 'IT,EN', 'danno' => '', 'eta_min' => 10, 'difficolta' => 'media', 'giocatori_min' => 1, 'giocatori_max' => 5, 'is_espansione' => false, 'novita' => true, 'in_top_venduti' => false, 'numero_vendite' => 95, 'data_inserimento' => '2026-05-15'],

    ['id' => 202, 'nome' => 'Azul',              'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.6, 'disponibilita' => 'disponibile', 'prezzo' => 32.90, 'sconto' => true,  'percentuale_sconto' => 10, 'prezzo_scontato' => 29.61,
        'categoria' => 'famiglia', 'lingue' => 'IT,EN,ES,DE', 'danno' => '', 'eta_min' => 8, 'difficolta' => 'facile', 'giocatori_min' => 2, 'giocatori_max' => 4, 'is_espansione' => false, 'novita' => false, 'in_top_venduti' => true, 'numero_vendite' => 410, 'data_inserimento' => '2023-06-01'],

    ['id' => 203, 'nome' => 'Brass Birmingham',  'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.9, 'disponibilita' => 'annunciato',  'prezzo' => 59.90, 'sconto' => false, 'percentuale_sconto' => null, 'prezzo_scontato' => null,
        'categoria' => 'strategia', 'lingue' => 'EN', 'danno' => '', 'eta_min' => 14, 'difficolta' => 'difficile', 'giocatori_min' => 2, 'giocatori_max' => 4, 'is_espansione' => false, 'novita' => true, 'in_top_venduti' => false, 'numero_vendite' => 60, 'data_inserimento' => '2026-06-01'],
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
        'id_item'    => 1,
        'quantita'   => 2,
        'subtotale'  => 55.84,
        'prodotto' => [
            'id'                 => 101,
            'nome'               => 'Catan',
            'immagine'           => 'placeholder.jpg',
            'prezzo_unitario'    => 27.92,
            'prezzo_originale'   => 34.90,
            'sconto'             => true,
            'percentuale_sconto' => 20,
            
        ],
        'update_url' => '/carrello/aggiorna/1',
        'remove_url' => '/carrello/rimuovi/1', // mancava anche questa, usata nel tpl
    ],
    [
        'id_item'    => 2,
        'quantita'   => 1,
        'subtotale'  => 49.90,
        'prodotto' => [
            'id'                 => 201,
            'nome'               => 'Wingspan',
            'immagine'           => 'placeholder.jpg',
            'prezzo_unitario'    => 49.90,
            'prezzo_originale'   => null,
            'sconto'             => false,
            'percentuale_sconto' => null,
        ],
        'update_url' => '/carrello/aggiorna/2',
        'remove_url' => '/carrello/rimuovi/2',
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
    'disponibilita' => 'in arrivo',
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
    'isAcquistabile' => false,
    'prezzo'        => 34.90,
    'prezzo_scontato' => 27.92,
];

// ── RECENSIONI ──
$recensioni = [
    [
        'name' => 'Marco92',
        'voto'     => 5,
        'titolo'   => 'Gioco fantastico!',
        'testo'    => "Lo gioco da anni con la mia famiglia, non ci stanchiamo mai.\nConsigliato a tutti!",
    ],
    [
        'name' => 'GiulyGamer',
        'voto'     => 4,
        'titolo'   => 'Ottimo ma un po\' lungo',
        'testo'    => 'Bellissimo gioco strategico, forse un po\' lungo per i bambini piccoli.',
    ],
];




// ── EVENTI: TORNEI ──
$eventi_tornei = [
    [
        'idEvento' => 301,
        'nomeEvento' => 'Torneo di Catan - Coppa Primavera',
        'imgEvento' => 'placeholder.jpg',
        'statoEvento' => 'Programmato',
        'maxPartecipanti' => 16,
        'numeroPartecipanti' => 10,
        'dataInizio' => '2026-07-15 18:30:00',
        'gioco' => ['nomeProdotto' => 'Catan'],
        'quota' => [
            'valore' => 10.00,
            'valuta' => 'EUR',
            'haSconto' => true,
            'prezzoScontato' => 8.00,
        ],
    ],
    [
        'idEvento' => 302,
        'nomeEvento' => 'Torneo 7 Wonders - Sfida Estiva',
        'imgEvento' => 'placeholder.jpg',
        'statoEvento' => 'Programmato',
        'maxPartecipanti' => 12,
        'numeroPartecipanti' => 12, // posti esauriti, utile per testare lo stepper a 0
        'dataInizio' => '2026-08-02 17:00:00',
        'gioco' => ['nomeProdotto' => '7 Wonders'],
        'quota' => [
            'valore' => 8.00,
            'valuta' => 'EUR',
            'haSconto' => false,
            'prezzoScontato' => null,
        ],
    ],
    [
        'idEvento' => 303,
        'nomeEvento' => 'Torneo Carcassonne - Edizione Invernale',
        'imgEvento' => 'placeholder.jpg',
        'statoEvento' => 'Terminato', // serve a testare il ramo "passato"
        'maxPartecipanti' => 16,
        'numeroPartecipanti' => 16,
        'dataInizio' => '2026-01-20 18:00:00',
        'gioco' => ['nomeProdotto' => 'Carcassonne'],
        'quota' => [
            'valore' => 10.00,
            'valuta' => 'EUR',
            'haSconto' => false,
            'prezzoScontato' => null,
        ],
    ],
];


// ── EVENTI: SERATE ──
$eventi_serate = [
    [
        'idEvento' => 401,
        'nomeEvento' => 'Serata Gioco Libero al Tablecrown Pub',
        'imgEvento' => 'placeholder.jpg',
        'statoEvento' => 'Programmato',
        'maxPartecipanti' => 30,
        'numeroPartecipanti' => 18,
        'dataInizio' => '2026-07-10 20:00:00',
        'tipoSerata' => 'Gioco Libero',
    ],
    [
        'idEvento' => 402,
        'nomeEvento' => 'Presentazione Brass Birmingham',
        'imgEvento' => 'placeholder.jpg',
        'statoEvento' => 'Programmato',
        'maxPartecipanti' => 20,
        'numeroPartecipanti' => 5,
        'dataInizio' => '2026-07-22 19:00:00',
        'tipoSerata' => 'Presentazione',
    ],
    [
        'idEvento' => 403,
        'nomeEvento' => 'Serata Azul - Edizione Autunnale',
        'imgEvento' => 'placeholder.jpg',
        'statoEvento' => 'Terminato',
        'maxPartecipanti' => 25,
        'numeroPartecipanti' => 25,
        'dataInizio' => '2025-11-05 20:30:00',
        'tipoSerata' => 'Gioco Libero',
    ],
];

// ── EVENTI: CHALLENGE ──
$eventi_challenge = [
    [
        'idEvento' => 501,
        'nomeEvento' => 'Challenge Wingspan - Stagione Migratoria',
        'imgEvento' => 'placeholder.jpg',
        'statoEvento' => 'Programmato',
        'maxPartecipanti' => 8,
        'numeroPartecipanti' => 3,
        'dataInizio' => '2026-07-28 16:00:00',
        'quota' => [
            'valore' => 5.00,
            'valuta' => 'EUR',
            'haSconto' => true,
            'prezzoScontato' => 4.00,
        ],
    ],
    [
        'idEvento' => 502,
        'nomeEvento' => 'Challenge Catan - Resa dei Conti',
        'imgEvento' => 'placeholder.jpg',
        'statoEvento' => 'Terminato',
        'maxPartecipanti' => 8,
        'numeroPartecipanti' => 8,
        'dataInizio' => '2026-02-14 18:00:00',
        'quota' => [
            'valore' => 5.00,
            'valuta' => 'EUR',
            'haSconto' => false,
            'prezzoScontato' => null,
        ],
    ],
];

// ── FILTRI (riflette ciò che arriva da querystring, anche se il mock non filtra davvero) ──
$filtri = [
    'data'      => $_GET['data'] ?? '',
    'stato'     => $_GET['stato'] ?? 'programma',
    'tipologia' => $_GET['tipologia'] ?? [],
];



$smarty->assign('utente', isset($_SESSION['utente_id'])
    ? ['nome' => $_SESSION['utente_nickname'] ?? 'Ospite', 'avatar' => null]
    : ['nome' => 'Ospite', 'avatar' => null]
);

$smarty->assign('account_menu', [
    ['label' => 'Modifica Account',    'url' => '/account/modifica'],
    ['label' => 'I Miei Ordini',       'url' => '/account/ordini'],
    ['label' => 'Le Mie Recensioni',   'url' => '/account/recensioni'],
    ['label' => 'I Miei Dadi',         'url' => '/account/dadi'],
    ['label' => 'Wishlist',            'url' => '/wishlist'],
    ['label' => 'Eventi',              'url' => '/eventi'],
    ['label' => 'I Miei Indirizzi',    'url' => '/account/indirizzi'],
]);

$smarty->assign('tornei_vinti',     3);
$smarty->assign('tornei_obiettivo', 10);





$smarty->assign('base_url',       BASE_URL);

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

$smarty->assign('cart_count', 5);




$smarty->assign('base_url',     BASE_URL);
$smarty->assign('offerte',      $offerte);
$smarty->assign('nuovi_arrivi', $nuovi_arrivi);



/*sta rona non so sicuro*/



$uriPath   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$categoria = $_GET['categoria'] ?? null;

if (!$categoria && preg_match('#^/catalogo/(tornei|serate|challenge)$#', $uriPath, $m)) {
    $categoria = $m[1];
}

if ($categoria === 'tornei') {
    $smarty->assign('eventi', $eventi_tornei);
    $smarty->assign('filtri', $filtri);
    $smarty->display('catalogo_tornei.tpl');
    exit;
}

if ($categoria === 'serate') {
    $smarty->assign('eventi', $eventi_serate);
    $smarty->assign('filtri', $filtri);
    $smarty->display('catalogo_serate.tpl');
    exit;
}

if ($categoria === 'challenge') {
    $smarty->assign('eventi', $eventi_challenge);
    $smarty->assign('filtri', $filtri);
    $smarty->display('catalogo_challenge.tpl');
    exit;
}



$smarty->assign('eventi', $eventi_tornei);
$smarty->assign('filtri', $filtri);




$smarty->display('ModificaAccount.tpl');