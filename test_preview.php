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
    ['id' => 101, 'nome' => 'Catan',            'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.5, 'disponibilita' => 'disponibile',
        'prezzo_unitario' => 27.92, 'prezzo_originale' => 34.90, 'sconto' => true,  'percentuale_sconto' => 20, 'isAcquistabile' => true,
        'categoria' => 'strategia', 'lingue' => 'IT,EN', 'danno' => '', 'eta_min' => 10, 'difficolta' => 'media', 'giocatori_min' => 3, 'giocatori_max' => 4, 'is_espansione' => false, 'novita' => false, 'in_top_venduti' => true, 'numero_vendite' => 340, 'data_inserimento' => '2024-03-10'],

    ['id' => 102, 'nome' => 'Carcassonne',       'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.0, 'disponibilita' => 'disponibile',
        'prezzo_unitario' => 25.42, 'prezzo_originale' => 29.90, 'sconto' => true,  'percentuale_sconto' => 15, 'isAcquistabile' => true,
        'categoria' => 'famiglia', 'lingue' => 'IT', 'danno' => '', 'eta_min' => 7, 'difficolta' => 'facile', 'giocatori_min' => 2, 'giocatori_max' => 5, 'is_espansione' => false, 'novita' => false, 'in_top_venduti' => false, 'numero_vendite' => 210, 'data_inserimento' => '2024-01-05'],

    ['id' => 103, 'nome' => '7 Wonders',         'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.7, 'disponibilita' => 'esaurito',
        'prezzo_unitario' => 39.90, 'prezzo_originale' => null, 'sconto' => false, 'percentuale_sconto' => null, 'isAcquistabile' => false,
        'categoria' => 'strategia', 'lingue' => 'IT,EN,FR', 'danno' => '', 'eta_min' => 10, 'difficolta' => 'media', 'giocatori_min' => 3, 'giocatori_max' => 7, 'is_espansione' => false, 'novita' => false, 'in_top_venduti' => true, 'numero_vendite' => 275, 'data_inserimento' => '2023-11-20'],

    ['id' => 201, 'nome' => 'Wingspan',          'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.8, 'disponibilita' => 'disponibile',
        'prezzo_unitario' => 49.90, 'prezzo_originale' => null, 'sconto' => false, 'percentuale_sconto' => null, 'isAcquistabile' => true,
        'categoria' => 'famiglia', 'lingue' => 'IT,EN', 'danno' => '', 'eta_min' => 10, 'difficolta' => 'media', 'giocatori_min' => 1, 'giocatori_max' => 5, 'is_espansione' => false, 'novita' => true, 'in_top_venduti' => false, 'numero_vendite' => 95, 'data_inserimento' => '2026-05-15'],

    ['id' => 202, 'nome' => 'Azul',              'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.6, 'disponibilita' => 'disponibile',
        'prezzo_unitario' => 29.61, 'prezzo_originale' => 32.90, 'sconto' => true,  'percentuale_sconto' => 10, 'isAcquistabile' => true,
        'categoria' => 'famiglia', 'lingue' => 'IT,EN,ES,DE', 'danno' => '', 'eta_min' => 8, 'difficolta' => 'facile', 'giocatori_min' => 2, 'giocatori_max' => 4, 'is_espansione' => false, 'novita' => false, 'in_top_venduti' => true, 'numero_vendite' => 410, 'data_inserimento' => '2023-06-01'],

    ['id' => 203, 'nome' => 'Brass Birmingham',  'immagine' => 'placeholder.jpg', 'valutazione_media' => 4.9, 'disponibilita' => 'annunciato',
        'prezzo_unitario' => 59.90, 'prezzo_originale' => null, 'sconto' => false, 'percentuale_sconto' => null, 'isAcquistabile' => false,
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
        'gioco' => 'Catan',
        'quotaIscrizione' => 10.00,
        'challenge' => [
            'idEvento'   => 501,
            'nomeEvento' => 'Challenge Wingspan - Stagione Migratoria',
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
        'gioco' => '7 Wonders',
        'quotaIscrizione' => 8.00,
        'challenge' => null,
    ],
    [
        'idEvento' => 303,
        'nomeEvento' => 'Torneo Carcassonne - Edizione Invernale',
        'imgEvento' => 'placeholder.jpg',
        'statoEvento' => 'Terminato', // serve a testare il ramo "passato"
        'maxPartecipanti' => 16,
        'numeroPartecipanti' => 16,
        'dataInizio' => '2026-01-20 18:00:00',
        'gioco' => 'Carcassonne',
        'quotaIscrizione' => 10.00,
        'challenge' => null,
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
        'tipoSerata' => 'gioco_libero',
    ],
    [
        'idEvento' => 402,
        'nomeEvento' => 'Presentazione Brass Birmingham',
        'imgEvento' => 'placeholder.jpg',
        'statoEvento' => 'Programmato',
        'maxPartecipanti' => 20,
        'numeroPartecipanti' => 5,
        'dataInizio' => '2026-07-22 19:00:00',
        'tipoSerata' => 'presentazione',
    ],
    [
        'idEvento' => 403,
        'nomeEvento' => 'Serata Azul - Edizione Autunnale',
        'imgEvento' => 'placeholder.jpg',
        'statoEvento' => 'Terminato',
        'maxPartecipanti' => 25,
        'numeroPartecipanti' => 25,
        'dataInizio' => '2025-11-05 20:30:00',
        'tipoSerata' => 'gioco_libero',
    ],
];

// ── EVENTI: CHALLENGE ──
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
        'quotaIscrizione' => 5.00,
        'premio' => 'Wingspan',
        'tornei' => [
            ['idEvento' => 301, 'nomeEvento' => 'Torneo di Catan - Coppa Primavera'],
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
        'quotaIscrizione' => 5.00,
        'premio' => 'Catan',
        'tornei' => [],
    ],
];

// ── FILTRI ──
$filtri = [
    'data'              => $_GET['data'] ?? '',
    'query_string'      => $_GET['query_string'] ?? '',
    'mostra_espansioni' => !isset($_GET['mostra_espansioni']) || $_GET['mostra_espansioni'] !== '0',
];

// ── BREADCRUMBS (per vista) ──
function breadcrumbsEventi(string $baseUrl, ?array $ultimo = null): array {
    $crumbs = [
        ['label' => 'Home',   'url' => $baseUrl . '/'],
        ['label' => 'Eventi', 'url' => $baseUrl . '/eventi'],
    ];
    if ($ultimo) {
        $crumbs[] = $ultimo;
    }
    return $crumbs;
}



$smarty->assign('utente', isset($_SESSION['utente_id'])
    ? ['nome' => $_SESSION['utente_nickname'] ?? 'Ospite', 'avatar' => null]
    : ['nome' => 'Ospite', 'avatar' => null]
);

$smarty->assign('account_menu', [
    ['label' => 'Modifica Account',    'url' => '/account/modifica'],
    ['label' => 'I Miei Ordini',       'url' => '/account/ordini'],
    ['label' => 'Le Mie Recensioni',   'url' => '/account/recensioni'],
    ['label' => 'Wishlist',            'url' => '/wishlist'],
    ['label' => 'Eventi',              'url' => '/eventi'],
    ['label' => 'I Miei Indirizzi',    'url' => '/account/indirizzi'],
]);


// ── WISHLIST (dati di test) ──
$wishlist = [
    [
        'id'                 => 101,
        'nome'               => 'Catan',
        'immagine'           => 'placeholder.jpg',
        'valutazione_media'  => 4.5,
        'prezzo'             => 34.90,
        'sconto'             => true,
        'prezzo_scontato'    => 27.92,
        'percentuale_sconto' => 20,
        'disponibilita'      => 'disponibile',
        'isAcquistabile'     => true,
    ],
    [
        'id'                 => 201,
        'nome'               => 'Wingspan',
        'immagine'           => 'placeholder.jpg',
        'valutazione_media'  => 4.8,
        'prezzo'             => 49.90,
        'sconto'             => false,
        'prezzo_scontato'    => null,
        'percentuale_sconto' => null,
        'disponibilita'      => 'disponibile',
        'isAcquistabile'     => true,
    ],
    [
        'id'                 => 103,
        'nome'               => '7 Wonders',
        'immagine'           => 'placeholder.jpg',
        'valutazione_media'  => 4.7,
        'prezzo'             => 39.90,
        'sconto'             => false,
        'prezzo_scontato'    => null,
        'percentuale_sconto' => null,
        'disponibilita'      => 'esaurito',
        'isAcquistabile'     => false,
    ],
    [
        'id'                 => 202,
        'nome'               => 'Azul',
        'immagine'           => 'placeholder.jpg',
        'valutazione_media'  => 4.6,
        'prezzo'             => 32.90,
        'sconto'             => true,
        'prezzo_scontato'    => 29.61,
        'percentuale_sconto' => 10,
        'disponibilita'      => 'disponibile',
        'isAcquistabile'     => true,
    ],
];


// ── LE MIE RECENSIONI (dati di test) ──
$recensioni_utente = [
    [
        'id'          => 1,
        'valutazione' => 5,
        'testo'       => "Lo gioco da anni con la mia famiglia, non ci stanchiamo mai.\nConsigliato a tutti!",
        'data'        => '10/07/2026',
        'prodotto'    => [
            'id'       => 101,
            'nome'     => 'Catan',
            'immagine' => 'placeholder.jpg',
        ],
        'isSegnalata' => false,
    ],
    [
        'id'          => 2,
        'valutazione' => 4,
        'testo'       => "Bellissimo gioco strategico, forse un po' lungo per i bambini piccoli.",
        'data'        => '02/06/2026',
        'prodotto'    => [
            'id'       => 201,
            'nome'     => 'Wingspan',
            'immagine' => 'placeholder.jpg',
        ],
        'isSegnalata' => false,
    ],
    [
        'id'          => 3,
        'valutazione' => 1,
        'testo'       => "Gioco terribile, non funziona niente, sconsigliatissimo a tutti quanti!!!",
        'data'        => '18/04/2026',
        'prodotto'    => [
            'id'       => 202,
            'nome'     => 'Azul',
            'immagine' => 'placeholder.jpg',
        ],
        'isSegnalata' => true,
    ],
];

// ── I MIEI ORDINI (dati di test) ──
$ordini_utente = [
    [
        'id'                      => 5001,
        'data'                    => '05/07/2026',
        'stato'                   => 'in_lavorazione',
        'totale'                  => 83.32,
        'indirizzoSpedizione'     => [
            'via'        => 'Via Roma 12',
            'citta'      => 'Pescara',
            'cap'        => '65121',
            'provincia'  => 'PE',
            'nazione'    => 'Italia',
        ],
        'ultimeQuattroCifreCarta' => '4242',
        'nomeTitolareCarta'       => 'Mario Rossi',
        'isAnnullabile'           => true,
        'items'                   => [
            [
                'prodotto'        => ['id' => 101, 'nome' => 'Catan', 'immagine' => 'placeholder.jpg'],
                'quantita'        => 1,
                'prezzoUnitario'  => 34.90,
                'scontoApplicato' => 20,
                'totaleItem'      => 27.92,
            ],
            [
                'prodotto'        => ['id' => 202, 'nome' => 'Azul', 'immagine' => 'placeholder.jpg'],
                'quantita'        => 1,
                'prezzoUnitario'  => 32.90,
                'scontoApplicato' => 10,
                'totaleItem'      => 29.61,
            ],
        ],
    ],
    [
        'id'                      => 4988,
        'data'                    => '20/06/2026',
        'stato'                   => 'spedito',
        'totale'                  => 49.90,
        'indirizzoSpedizione'     => [
            'via'        => 'Via Roma 12',
            'citta'      => 'Pescara',
            'cap'        => '65121',
            'provincia'  => 'PE',
            'nazione'    => 'Italia',
        ],
        'ultimeQuattroCifreCarta' => '4242',
        'nomeTitolareCarta'       => 'Mario Rossi',
        'isAnnullabile'           => false,
        'items'                   => [
            [
                'prodotto'        => ['id' => 201, 'nome' => 'Wingspan', 'immagine' => 'placeholder.jpg'],
                'quantita'        => 1,
                'prezzoUnitario'  => 49.90,
                'scontoApplicato' => 0,
                'totaleItem'      => 49.90,
            ],
        ],
    ],
    [
        'id'                      => 4870,
        'data'                    => '02/03/2026',
        'stato'                   => 'consegnato',
        'totale'                  => 39.90,
        'indirizzoSpedizione'     => [
            'via'        => 'Via Roma 12',
            'citta'      => 'Pescara',
            'cap'        => '65121',
            'provincia'  => 'PE',
            'nazione'    => 'Italia',
        ],
        'ultimeQuattroCifreCarta' => '4242',
        'nomeTitolareCarta'       => 'Mario Rossi',
        'isAnnullabile'           => false,
        'items'                   => [
            [
                'prodotto'        => ['id' => 103, 'nome' => '7 Wonders', 'immagine' => 'placeholder.jpg'],
                'quantita'        => 1,
                'prezzoUnitario'  => 39.90,
                'scontoApplicato' => 0,
                'totaleItem'      => 39.90,
            ],
        ],
    ],
    [
        'id'                      => 4801,
        'data'                    => '10/01/2026',
        'stato'                   => 'annullato',
        'totale'                  => 25.42,
        'indirizzoSpedizione'     => [
            'via'        => 'Via Roma 12',
            'citta'      => 'Pescara',
            'cap'        => '65121',
            'provincia'  => 'PE',
            'nazione'    => 'Italia',
        ],
        'ultimeQuattroCifreCarta' => '4242',
        'nomeTitolareCarta'       => 'Mario Rossi',
        'isAnnullabile'           => false,
        'items'                   => [
            [
                'prodotto'        => ['id' => 102, 'nome' => 'Carcassonne', 'immagine' => 'placeholder.jpg'],
                'quantita'        => 1,
                'prezzoUnitario'  => 29.90,
                'scontoApplicato' => 15,
                'totaleItem'      => 25.42,
            ],
        ],
    ],
];




// 1) Aggiungi 'profilo_eventi' alla whitelist $_GET['page']
$paginheWhitelist = [
    // ... le tue pagine esistenti
    'profilo_eventi',
];

// 2) Blocco mock per 'profilo_eventi'

// ── PROFILO EVENTI (mock) ──
$eventi_profilo = [
    [
        'idEvento'              => 1,
        'nomeEvento'            => 'Serata Giochi da Tavolo',
        'imgEvento'             => 'placeholder.jpg',
        'dataInizio'            => '20/07/2026',
        'maxPartecipanti'       => 20,
        'statoEvento'           => 'confermato',
        'numeroPartecipanti'    => 14,
        'tipoEvento'            => 'serata',
        'tipoSerata'            => 'Giochi di strategia',
        'dataIscrizione'        => '01/07/2026',
        'posizioneInClassifica' => null,
        'quotaPagata'           => true,
        'isDisdicibile'         => true,
    ],
    [
        'idEvento'              => 2,
        'nomeEvento'            => 'Torneo Scacchi Estivo',
        'imgEvento'             => 'placeholder.jpg',
        'dataInizio'            => '25/07/2026',
        'maxPartecipanti'       => 32,
        'statoEvento'           => 'confermato',
        'numeroPartecipanti'    => 30,
        'tipoEvento'            => 'torneo',
        'quotaIscrizione'       => '10.00',
        'premio'                => 'Trofeo + buono da 50€',
        'gioco'                 => 'Scacchi',
        'challenge'             => [
            'idEvento'   => 12,
            'nomeEvento' => "Challenge d'Autunno",
        ],
        'dataIscrizione'        => '05/07/2026',
        'posizioneInClassifica' => 3,
        'quotaPagata'           => false,
        'isDisdicibile'         => true,
    ],
    [
        'idEvento'              => 12,
        'nomeEvento'            => "Challenge d'Autunno",
        'imgEvento'             => null,
        'dataInizio'            => '10/09/2026',
        'maxPartecipanti'       => 64,
        'statoEvento'           => 'aperto',
        'numeroPartecipanti'    => 40,
        'tipoEvento'            => 'challenge',
        'quotaIscrizione'       => '20.00',
        'premio'                => 'Coppa Challenge + montepremi',
        'tornei'                => [
            ['idEvento' => 21, 'nomeEvento' => 'Torneo Scacchi - Girone A'],
            ['idEvento' => 22, 'nomeEvento' => 'Torneo Scacchi - Girone B'],
        ],
        'dataIscrizione'        => '02/07/2026',
        'posizioneInClassifica' => null,
        'quotaPagata'           => true,
        'isDisdicibile'         => false,
    ],
];




// ── PROFILO INDIRIZZI (mock) ──
$indirizzi_profilo = [
    [
        'id'           => 1,
        'nome'         => 'Casa',
        'via'          => 'Via Roma 12',
        'citta'        => 'Pescara',
        'cap'          => '65121',
        'provincia'    => 'PE',
        'nazione'      => 'Italia',
        'nomeCitofono' => 'Rossi',
        'predefinito'  => true,
    ],
    [
        'id'           => 2,
        'nome'         => 'Ufficio',
        'via'          => 'Corso Umberto I 45',
        'citta'        => 'Giulianova',
        'cap'          => '64021',
        'provincia'    => 'TE',
        'nazione'      => 'Italia',
        'nomeCitofono' => '',
        'predefinito'  => false,
    ],
];



// ── CHALLENGE SINGOLA (per dettagliChallenge.tpl) ──
$challenge_dettaglio = [
    'id'            => 501,
    'nome'          => 'Challenge Wingspan - Stagione Migratoria',
    'immagine'      => 'placeholder.jpg',
    'data'          => '28/07/2026',
    'postiLiberi'   => 5,
    'postiTotali'   => 8,
    'nomeAttivita'  => 'Wingspan',
    'descrizione'   => "Metti alla prova le tue abilità in Wingspan in questa challenge stagionale.\nAffronta più tornei collegati e scala la classifica generale.",
    'prezzo'        => 5.00,
    'premio'        => ['id' => 201, 'nome' => 'Wingspan', 'immagine' => 'placeholder.jpg'],
    'tornei'        => [
        ['id' => 301, 'nome' => 'Torneo di Catan - Coppa Primavera', 'immagine' => 'placeholder.jpg', 'data' => '15/07/2026'],
    ],
];



// ── TORNEO SINGOLO (per dettagliTorneo.tpl) ──
$torneo_dettaglio = [
    'id'            => 301,
    'nome'          => 'Torneo di Catan - Coppa Primavera',
    'immagine'      => 'placeholder.jpg',
    'data'          => '15/07/2026',
    'postiLiberi'   => 6,
    'postiTotali'   => 16,
    'nomeAttivita'  => 'Catan',
    'descrizione'   => "Sfida gli altri giocatori nel torneo ufficiale di Catan.\nFormula a gironi, finale in diretta con premiazione.",
    'prezzo'        => 10.00,
    'premio'        => ['id' => 101, 'nome' => 'Catan', 'immagine' => 'placeholder.jpg'],
    'challenge'     => [
        'id'       => 501,
        'nome'     => 'Challenge Wingspan - Stagione Migratoria',
        'immagine' => 'placeholder.jpg',
    ],
];

// ── SERATA SINGOLA (per dettagliSerata.tpl) ──
$serata_dettaglio = [
    'id'            => 401,
    'nome'          => 'Serata Gioco Libero al Tablecrown Pub',
    'immagine'      => 'placeholder.jpg',
    'data'          => '10/07/2026',
    'postiLiberi'   => 12,
    'postiTotali'   => 30,
    'nomeAttivita'  => 'Gioco Libero',
    'descrizione'   => "Una serata di gioco libero aperta a tutti gli appassionati.\nPortare la propria copia o usare quelle disponibili in sede.",
    'recensioni'    => [
        ['utente' => 'Marco92',    'data' => '01/07/2026', 'testo' => "Ambiente accogliente, tornerò sicuramente!"],
        ['utente' => 'GiulyGamer', 'data' => '20/06/2026', 'testo' => "Bella iniziativa, un po' affollata ma divertente."],
    ],
];

$smarty->assign('serata', $serata_dettaglio);


$smarty->assign('torneo', $torneo_dettaglio);


$smarty->assign('challenge', $challenge_dettaglio);


$smarty->assign('indirizzi', $indirizzi_profilo);

// ── Home eventi (le 3 card) ──
$smarty->assign('eventi', $eventi_profilo);
$smarty->assign('ordinamento_eventi', $_GET['ordinamento'] ?? 'futuri');
$smarty->assign('filtri', $filtri);
$smarty->assign('breadcrumbs', breadcrumbsEventi(BASE_URL));








$smarty->assign('ordini', $ordini_utente);




$smarty->assign('recensioni', $recensioni_utente);


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
    $smarty->assign('breadcrumbs', breadcrumbsEventi(BASE_URL, ['label' => 'Tornei', 'url' => BASE_URL . '/catalogo/tornei']));
    $smarty->display('catalogo_tornei.tpl');
    exit;
}

if ($categoria === 'serate') {
    $smarty->assign('eventi', $eventi_serate);
    $smarty->assign('filtri', $filtri);
    $smarty->assign('breadcrumbs', breadcrumbsEventi(BASE_URL, ['label' => 'Serate', 'url' => BASE_URL . '/catalogo/serate']));
    $smarty->display('catalogo_serate.tpl');
    exit;
}

if ($categoria === 'challenge') {
    $smarty->assign('eventi', $eventi_challenge);
    $smarty->assign('filtri', $filtri);
    $smarty->assign('breadcrumbs', breadcrumbsEventi(BASE_URL, ['label' => 'Challenge', 'url' => BASE_URL . '/catalogo/challenge']));
    $smarty->display('catalogo_challenge.tpl');
    exit;
}

// Home eventi (le 3 card)
$smarty->assign('filtri', $filtri);
$smarty->assign('breadcrumbs', breadcrumbsEventi(BASE_URL));
$smarty->display('checkout.tpl');