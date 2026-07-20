<?php

require_once __DIR__ . '/config.php';

require_once __DIR__ . '/vendor/autoload.php';

use Smarty\Smarty;
$smarty = new Smarty();
$smarty->setTemplateDir(SMARTY_DIR . 'templates/');
$smarty->setCompileDir(SMARTY_DIR  . 'templates_c/');
$smarty->setCacheDir(SMARTY_DIR    . 'cache/');
$smarty->setConfigDir(SMARTY_DIR   . 'configs/');


// ══════════════════════════════════════════════════════════════
//  MOCK EVENTI (per le 3 pagine LISTA eventi)
//  NB: DEVONO stare PRIMA di $mappaVisteListe, che li referenzia.
// ══════════════════════════════════════════════════════════════

// ── MOCK EVENTI: SERATE (struttura di serataToArray()) ──
$eventi_serate = [
    [
        'idEvento'           => 401,
        'nomeEvento'         => 'Serata Gioco Libero al Tablecrown Pub',
        'imgEvento'          => BASE_URL . '/img/placeholder.jpg',
        'dataInizio'         => '2026-07-10 20:00:00',
        'maxPartecipanti'    => 30,
        'statoEvento'        => 'Programmato',
        'numeroPartecipanti' => 18,
        'richiedeQuota'      => false,
        'postiDisponibili'   => 12,
        'tipo'               => 'serata',
        'tipoSerata'         => 'Gioco Libero',
    ],
    [
        'idEvento'           => 402,
        'nomeEvento'         => 'Presentazione Brass Birmingham',
        'imgEvento'          => BASE_URL . '/img/placeholder.jpg',
        'dataInizio'         => '2026-07-22 19:00:00',
        'maxPartecipanti'    => 20,
        'statoEvento'        => 'Programmato',
        'numeroPartecipanti' => 20,
        'richiedeQuota'      => false,
        'postiDisponibili'   => 0,
        'tipo'               => 'serata',
        'tipoSerata'         => 'Presentazione',
    ],
    [
        'idEvento'           => 403,
        'nomeEvento'         => 'Serata Azul - Edizione Autunnale',
        'imgEvento'          => BASE_URL . '/img/placeholder.jpg',
        'dataInizio'         => '2025-11-05 20:30:00',
        'maxPartecipanti'    => 25,
        'statoEvento'        => 'Terminato',
        'numeroPartecipanti' => 25,
        'richiedeQuota'      => false,
        'postiDisponibili'   => 0,
        'tipo'               => 'serata',
        'tipoSerata'         => 'Gioco Libero',
    ],
];

// ── MOCK EVENTI: TORNEI (struttura di torneoToArray()) ──
$eventi_tornei = [
    [
        'idEvento'           => 301,
        'nomeEvento'         => 'Torneo di Catan - Coppa Primavera',
        'imgEvento'          => BASE_URL . '/img/placeholder.jpg',
        'dataInizio'         => '2026-07-15 18:30:00',
        'maxPartecipanti'    => 16,
        'statoEvento'        => 'Programmato',
        'numeroPartecipanti' => 10,
        'richiedeQuota'      => true,
        'postiDisponibili'   => 6,
        'tipo'               => 'torneo',
        'quotaIscrizione'    => 10.00,
        'premio'             => 'Catan',
        'gioco'              => 'Catan',
        'challenge'          => [
            'idEvento'   => 501,
            'nomeEvento' => 'Challenge Wingspan - Stagione Migratoria',
        ],
    ],
    [
        'idEvento'           => 302,
        'nomeEvento'         => 'Torneo 7 Wonders - Sfida Estiva',
        'imgEvento'          => BASE_URL . '/img/placeholder.jpg',
        'dataInizio'         => '2026-08-02 17:00:00',
        'maxPartecipanti'    => 12,
        'statoEvento'        => 'Programmato',
        'numeroPartecipanti' => 12,
        'richiedeQuota'      => true,
        'postiDisponibili'   => 0,
        'tipo'               => 'torneo',
        'quotaIscrizione'    => 8.00,
        'premio'             => '7 Wonders',
        'gioco'              => '7 Wonders',
        'challenge'          => null,
    ],
    [
        'idEvento'           => 303,
        'nomeEvento'         => 'Torneo Carcassonne - Edizione Invernale',
        'imgEvento'          => BASE_URL . '/img/placeholder.jpg',
        'dataInizio'         => '2026-01-20 18:00:00',
        'maxPartecipanti'    => 16,
        'statoEvento'        => 'Terminato',
        'numeroPartecipanti' => 16,
        'richiedeQuota'      => true,
        'postiDisponibili'   => 0,
        'tipo'               => 'torneo',
        'quotaIscrizione'    => 10.00,
        'premio'             => 'Carcassonne',
        'gioco'              => 'Carcassonne',
        'challenge'          => null,
    ],
];

// ── MOCK EVENTI: CHALLENGE (struttura di challengeToArray()) ──
$eventi_challenge = [
    [
        'idEvento'           => 501,
        'nomeEvento'         => 'Challenge Wingspan - Stagione Migratoria',
        'imgEvento'          => BASE_URL . '/img/placeholder.jpg',
        'dataInizio'         => '2026-07-28 16:00:00',
        'maxPartecipanti'    => 8,
        'statoEvento'        => 'Programmato',
        'numeroPartecipanti' => 3,
        'richiedeQuota'      => true,
        'postiDisponibili'   => 5,
        'tipo'               => 'challenge',
        'quotaIscrizione'    => 5.00,
        'premio'             => 'Wingspan',
        'tornei'             => [
            ['idEvento' => 301, 'nomeEvento' => 'Torneo di Catan - Coppa Primavera'],
        ],
    ],
    [
        'idEvento'           => 502,
        'nomeEvento'         => 'Challenge Catan - Resa dei Conti',
        'imgEvento'          => BASE_URL . '/img/placeholder.jpg',
        'dataInizio'         => '2026-02-14 18:00:00',
        'maxPartecipanti'    => 8,
        'statoEvento'        => 'Terminato',
        'numeroPartecipanti' => 8,
        'richiedeQuota'      => true,
        'postiDisponibili'   => 0,
        'tipo'               => 'challenge',
        'quotaIscrizione'    => 5.00,
        'premio'             => 'Catan',
        'tornei'             => [],
    ],
];


// ══════════════════════════════════════════════════════════════
//  MOCK PRODOTTI (per gestore_prodotti.tpl)
// ══════════════════════════════════════════════════════════════
$prodotti_gestore = [
    [
        'id'                 => 101,
        'nome'               => 'Catan',
        'immagine'           => BASE_URL . '/img/placeholder.jpg',
        'tipo'               => 'Gioco da Tavolo',
        'tipoSlug'           => 'giochi-da-tavolo',
        'quantita'           => 14,
        'valutazione_media'  => 4.6,
        'prezzo'             => 34.90,
        'sconto'             => false,
        'prezzo_scontato'    => null,
        'percentuale_sconto' => null,
        'disponibilita'      => 'Disponibile',
        'isAcquistabile'     => true,
        'danneggiato'        => false,
        'livello_danno'      => null,
    ],
    [
        'id'                 => 102,
        'nome'               => '7 Wonders',
        'immagine'           => BASE_URL . '/img/placeholder.jpg',
        'tipo'               => 'Gioco da Tavolo',
        'tipoSlug'           => 'giochi-da-tavolo',
        'quantita'           => 0,
        'valutazione_media'  => 4.4,
        'prezzo'             => 39.90,
        'sconto'             => true,
        'prezzo_scontato'    => 29.90,
        'percentuale_sconto' => 25,
        'disponibilita'      => 'Esaurito',
        'isAcquistabile'     => false,
        'danneggiato'        => false,
        'livello_danno'      => null,
    ],
    [
        'id'                 => 103,
        'nome'               => 'Carcassonne',
        'immagine'           => BASE_URL . '/img/placeholder.jpg',
        'tipo'               => 'Gioco da Tavolo',
        'tipoSlug'           => 'giochi-da-tavolo',
        'quantita'           => 22,
        'valutazione_media'  => 4.5,
        'prezzo'             => 27.50,
        'sconto'             => false,
        'prezzo_scontato'    => null,
        'percentuale_sconto' => null,
        'disponibilita'      => 'Disponibile',
        'isAcquistabile'     => true,
        // Prodotto di test per il caso "già danneggiato": apri il modale su questo
        // gioco per vedere checkbox precaricata, livello e riepilogo stato attuale.
        'danneggiato'        => true,
        'livello_danno'      => 'moderato',
    ],
    [
        'id'                 => 201,
        'nome'               => 'Bustina Espansione Draghi',
        'immagine'           => BASE_URL . '/img/placeholder.jpg',
        'tipo'               => 'Bustine',
        'tipoSlug'           => 'bustine',
        'quantita'           => 50,
        'valutazione_media'  => 4.1,
        'prezzo'             => 4.50,
        'sconto'             => false,
        'prezzo_scontato'    => null,
        'percentuale_sconto' => null,
        'disponibilita'      => 'Disponibile',
        'isAcquistabile'     => true,
        // Le bustine non sono EGiocoDaTavolo: danneggiato resta sempre false/null
        // (coerente con prodottoToArray(), che valorizza il danno solo per i giochi)
        'danneggiato'        => false,
        'livello_danno'      => null,
    ],
    [
        'id'                 => 202,
        'nome'               => 'Bustina Edizione Limitata',
        'immagine'           => BASE_URL . '/img/placeholder.jpg',
        'tipo'               => 'Bustine',
        'tipoSlug'           => 'bustine',
        'quantita'           => 3,
        'valutazione_media'  => 4.8,
        'prezzo'             => 6.90,
        'sconto'             => true,
        'prezzo_scontato'    => 5.90,
        'percentuale_sconto' => 15,
        'disponibilita'      => 'Disponibile',
        'isAcquistabile'     => true,
        'danneggiato'        => false,
        'livello_danno'      => null,
    ],
    [
        'id'                 => 301,
        'nome'               => 'Porta Dadi in Legno - Quercia',
        'immagine'           => BASE_URL . '/img/placeholder.jpg',
        'tipo'               => 'Porta Dadi',
        'tipoSlug'           => 'porta-dadi',
        'quantita'           => 8,
        'valutazione_media'  => 4.9,
        'prezzo'             => 18.00,
        'sconto'             => false,
        'prezzo_scontato'    => null,
        'percentuale_sconto' => null,
        'disponibilita'      => 'Disponibile',
        'isAcquistabile'     => true,
        'danneggiato'        => false,
        'livello_danno'      => null,
    ],
    [
        'id'                 => 302,
        'nome'               => 'Porta Dadi in Metallo - Nero Opaco',
        'immagine'           => BASE_URL . '/img/placeholder.jpg',
        'tipo'               => 'Porta Dadi',
        'tipoSlug'           => 'porta-dadi',
        'quantita'           => 0,
        'valutazione_media'  => 4.2,
        'prezzo'             => 22.00,
        'sconto'             => false,
        'prezzo_scontato'    => null,
        'percentuale_sconto' => null,
        'disponibilita'      => 'Non Disponibile',
        'isAcquistabile'     => false,
        'danneggiato'        => false,
        'livello_danno'      => null,
    ],
];

// ── Enum Disponibilità (placeholder, da confermare con l'entity reale via enumToOptions()) ──
$disponibilita_enum = [
    ['value' => 'Disponibile', 'label' => 'Disponibile'],
    ['value' => 'Esaurito', 'label' => 'Esaurito'],
    ['value' => 'Non Disponibile', 'label' => 'Non Disponibile'],
];

// ── Enum Livello Danno (placeholder, da confermare con l'entity reale) ──
$livelloDanno_enum = [
    ['value' => 'lieve', 'label' => 'Lieve'],
    ['value' => 'moderato', 'label' => 'Moderato'],
    ['value' => 'grave', 'label' => 'Grave'],
];


// ══════════════════════════════════════════════════════════════
//  MOCK DETTAGLIO EVENTI (gestore)
//  Struttura = quella prodotta da BaseController::costruisciDatiVistaEvento()
//  con modalita: 'gestore'. Includo anche 'podio' e 'iscritti' (torneo) e
//  il campo 'podio'/'iscritti' annidato in ogni torneo di una challenge:
//  questi campi NON sono ancora popolati dal controller reale (vedi TODO
//  segnalati a Control), ma servono qui per poter vedere/testare la UI.
//
//  Ogni blocco sotto è una VARIANTE pensata per un singolo statoEvento,
//  così puoi cambiare $vistaCorrente per vedere tutti i casi della tabella
//  pulsanti (sezione 2/3/4 del documento).
// ══════════════════════════════════════════════════════════════

// ── SERATA: una variante per stato ──
$dettaglio_serata_base = [
    'idEvento'           => 401,
    'nomeEvento'         => 'Serata Gioco Libero al Tablecrown Pub',
    'imgEvento'          => BASE_URL . '/img/placeholder.jpg',
    'maxPartecipanti'    => 30,
    'numeroPartecipanti' => 18,
    'richiedeQuota'      => false,
    'postiDisponibili'   => 12,
    'tipo'               => 'serata',
    'tipoSerata'         => 'Gioco Libero',
    'descrizioneEvento'  => "Una serata di gioco libero aperta a tutti: porta il tuo gioco preferito o scegline uno dalla nostra ludoteca.\nBar e snack disponibili per tutta la durata dell'evento.",
    'postiRimanenti'     => 12,
    'hasPostiDisponibili'=> true,
    'userIscritto'       => false,
    'vista'              => 'gestore_dettaglio_serata',
];

$dettagli_serata = [
    'programmato_futura' => array_merge($dettaglio_serata_base, [
        'statoEvento' => 'Programmato',
        'dataInizio'  => '2026-08-10 20:00:00', // futura -> "Attiva" nascosto
    ]),
    'programmato_passata' => array_merge($dettaglio_serata_base, [
        'idEvento'    => 404,
        'nomeEvento'  => 'Serata Gioco Libero (in attesa di avvio)',
        'statoEvento' => 'Programmato',
        'dataInizio'  => '2026-07-01 20:00:00', // già passata -> "Attiva" visibile
    ]),
    'in_corso' => array_merge($dettaglio_serata_base, [
        'idEvento'    => 405,
        'nomeEvento'  => 'Serata Gioco Libero (in corso adesso)',
        'statoEvento' => 'In_corso',
        'dataInizio'  => '2026-07-19 20:00:00',
    ]),
    'terminato' => array_merge($dettaglio_serata_base, [
        'idEvento'           => 403,
        'nomeEvento'         => 'Serata Azul - Edizione Autunnale',
        'tipoSerata'         => 'Gioco Libero',
        'statoEvento'        => 'Terminato',
        'dataInizio'         => '2025-11-05 20:30:00',
        'numeroPartecipanti' => 25,
        'maxPartecipanti'    => 25,
        'postiDisponibili'   => 0,
        'postiRimanenti'     => 0,
        'hasPostiDisponibili'=> false,
    ]),
    'annullato' => array_merge($dettaglio_serata_base, [
        'idEvento'    => 406,
        'nomeEvento'  => 'Serata Presentazione Brass Birmingham (annullata)',
        'statoEvento' => 'Annullato',
        'dataInizio'  => '2026-07-22 19:00:00',
    ]),
];

// ── TORNEO: varianti per stato, + podio/iscritti per il caso 'terminato' ──
$premio_catan = [
    'id'                 => 101,
    'nome'               => 'Catan',
    'immagine'           => BASE_URL . '/img/placeholder.jpg',
    'valutazione_media'  => 4.6,
    'prezzo'             => 34.90,
    'sconto'             => false,
    'prezzo_scontato'    => null,
    'percentuale_sconto' => null,
    'disponibilita'      => 'Disponibile',
    'isAcquistabile'     => true,
];

$iscritti_torneo_301 = [
    ['id' => 1, 'nome' => 'Marco Bianchi'],
    ['id' => 2, 'nome' => 'Giulia Verdi'],
    ['id' => 3, 'nome' => 'Luca Neri'],
    ['id' => 4, 'nome' => 'Sara Colombo'],
];

$dettaglio_torneo_base = [
    'idEvento'           => 301,
    'nomeEvento'         => 'Torneo di Catan - Coppa Primavera',
    'imgEvento'          => BASE_URL . '/img/placeholder.jpg',
    'maxPartecipanti'    => 16,
    'numeroPartecipanti' => 10,
    'richiedeQuota'      => true,
    'postiDisponibili'   => 6,
    'tipo'               => 'torneo',
    'quotaIscrizione'    => 10.00,
    'premio'             => $premio_catan,
    'gioco'              => 'Catan',
    'challenge'          => ['idEvento' => 501, 'nomeEvento' => 'Challenge Wingspan - Stagione Migratoria'],
    'descrizioneEvento'  => "Torneo a eliminazione diretta su 3 turni. Iscrizione obbligatoria entro la data di inizio.\nIl vincitore accede automaticamente alla classifica generale della Challenge collegata.",
    'postiRimanenti'     => 6,
    'hasPostiDisponibili'=> true,
    'userIscritto'       => false,
    'vista'              => 'gestore_dettaglio_torneo',
];

$dettagli_torneo = [
    'programmato_futura' => array_merge($dettaglio_torneo_base, [
        'statoEvento' => 'Programmato',
        'dataInizio'  => '2026-08-10 18:30:00',
    ]),
    'programmato_passata' => array_merge($dettaglio_torneo_base, [
        'idEvento'    => 307,
        'statoEvento' => 'Programmato',
        'dataInizio'  => '2026-07-01 18:30:00',
    ]),
    'in_corso' => array_merge($dettaglio_torneo_base, [
        'idEvento'    => 308,
        'statoEvento' => 'In_corso',
        'dataInizio'  => '2026-07-19 18:30:00',
    ]),
    'annullato' => array_merge($dettaglio_torneo_base, [
        'idEvento'    => 309,
        'statoEvento' => 'Annullato',
        'dataInizio'  => '2026-07-22 18:30:00',
    ]),
    // Terminato SENZA podio ancora inserito -> mostra "Aggiungi esito"
    'terminato_senza_podio' => array_merge($dettaglio_torneo_base, [
        'idEvento'           => 303,
        'nomeEvento'         => 'Torneo Carcassonne - Edizione Invernale',
        'gioco'              => 'Carcassonne',
        'premio'             => array_merge($premio_catan, ['id' => 103, 'nome' => 'Carcassonne']),
        'challenge'          => null,
        'statoEvento'        => 'Terminato',
        'dataInizio'         => '2026-01-20 18:00:00',
        'numeroPartecipanti' => 16,
        'maxPartecipanti'    => 16,
        'postiDisponibili'   => 0,
        'postiRimanenti'     => 0,
        'hasPostiDisponibili'=> false,
        'iscritti'           => $iscritti_torneo_301,
        // 'podio' assente volutamente: simula il caso "nessun esito ancora inserito"
    ]),
    // Terminato CON podio già inserito -> mostra "Modifica esito" + podio in sola lettura
    'terminato_con_podio' => array_merge($dettaglio_torneo_base, [
        'statoEvento'        => 'Terminato',
        'dataInizio'         => '2026-06-10 18:30:00',
        'numeroPartecipanti' => 10,
        'postiDisponibili'   => 6,
        'postiRimanenti'     => 6,
        'hasPostiDisponibili'=> true,
        'iscritti'           => $iscritti_torneo_301,
        'podio' => [
            ['posizione' => 1, 'utente' => ['id' => 2, 'nome' => 'Giulia Verdi']],
            ['posizione' => 2, 'utente' => ['id' => 1, 'nome' => 'Marco Bianchi']],
            ['posizione' => 3, 'utente' => ['id' => 4, 'nome' => 'Sara Colombo']],
        ],
    ]),
];

// ── CHALLENGE: varianti (classifica non generata con tornei mancanti / classifica generata) ──
$premio_wingspan = array_merge($premio_catan, ['id' => 104, 'nome' => 'Wingspan']);

// Tornei "figli" completi (torneoToArray() + podio/iscritti annidati, come servirebbe
// nella sezione 4 del documento). Uno ha già podio, uno no.
$torneo_figlio_con_podio = [
    'idEvento'           => 301,
    'nomeEvento'         => 'Torneo di Catan - Coppa Primavera',
    'imgEvento'          => BASE_URL . '/img/placeholder.jpg',
    'dataInizio'         => '2026-06-10 18:30:00',
    'maxPartecipanti'    => 16,
    'statoEvento'        => 'Terminato',
    'numeroPartecipanti' => 10,
    'richiedeQuota'      => true,
    'postiDisponibili'   => 6,
    'tipo'               => 'torneo',
    'quotaIscrizione'    => 10.00,
    'premio'             => 'Catan',
    'gioco'              => 'Catan',
    'challenge'          => ['idEvento' => 501, 'nomeEvento' => 'Challenge Wingspan - Stagione Migratoria'],
    'iscritti'           => $iscritti_torneo_301,
    'podio' => [
        ['posizione' => 1, 'utente' => ['id' => 2, 'nome' => 'Giulia Verdi']],
        ['posizione' => 2, 'utente' => ['id' => 1, 'nome' => 'Marco Bianchi']],
        ['posizione' => 3, 'utente' => ['id' => 4, 'nome' => 'Sara Colombo']],
    ],
];

$torneo_figlio_senza_podio = [
    'idEvento'           => 306,
    'nomeEvento'         => 'Torneo Wingspan - Volo Libero',
    'imgEvento'          => BASE_URL . '/img/placeholder.jpg',
    'dataInizio'         => '2026-06-15 18:00:00',
    'maxPartecipanti'    => 12,
    'statoEvento'        => 'Terminato',
    'numeroPartecipanti' => 8,
    'richiedeQuota'      => true,
    'postiDisponibili'   => 4,
    'tipo'               => 'torneo',
    'quotaIscrizione'    => 6.00,
    'premio'             => 'Wingspan',
    'gioco'              => 'Wingspan',
    'challenge'          => ['idEvento' => 501, 'nomeEvento' => 'Challenge Wingspan - Stagione Migratoria'],
    'iscritti'           => [
        ['id' => 5, 'nome' => 'Elena Ferrari'],
        ['id' => 6, 'nome' => 'Davide Romano'],
        ['id' => 7, 'nome' => 'Chiara Greco'],
    ],
    // 'podio' assente: questo torneo manca ancora l'esito
];

$dettaglio_challenge_base = [
    'idEvento'           => 501,
    'nomeEvento'         => 'Challenge Wingspan - Stagione Migratoria',
    'imgEvento'          => BASE_URL . '/img/placeholder.jpg',
    'maxPartecipanti'    => 8,
    'richiedeQuota'      => true,
    'quotaIscrizione'    => 5.00,
    'premio'             => $premio_wingspan,
    'tipo'               => 'challenge',
    'descrizioneEvento'  => "Challenge stagionale su 2 tornei collegati. La classifica finale somma i punti ottenuti in ciascun torneo.\nIl premio finale va al primo classificato della classifica generale.",
    'punteggi'           => ['primo' => 10, 'secondo' => 6, 'terzo' => 3],
    'userIscritto'       => false,
    'vista'              => 'gestore_dettaglio_challenge',
];

$dettagli_challenge = [
    'programmato_futura' => array_merge($dettaglio_challenge_base, [
        'statoEvento'        => 'Programmato',
        'dataInizio'         => '2026-08-28 16:00:00',
        'numeroPartecipanti' => 3,
        'postiDisponibili'   => 5,
        'postiRimanenti'     => 5,
        'hasPostiDisponibili'=> true,
        'tornei'             => [$torneo_figlio_senza_podio],
    ]),
    'in_corso' => array_merge($dettaglio_challenge_base, [
        'idEvento'           => 503,
        'statoEvento'        => 'In_corso',
        'dataInizio'         => '2026-07-19 16:00:00',
        'numeroPartecipanti' => 6,
        'postiDisponibili'   => 2,
        'postiRimanenti'     => 2,
        'hasPostiDisponibili'=> true,
        'tornei'             => [$torneo_figlio_con_podio, $torneo_figlio_senza_podio],
    ]),
    'annullato' => array_merge($dettaglio_challenge_base, [
        'idEvento'           => 504,
        'statoEvento'        => 'Annullato',
        'dataInizio'         => '2026-07-22 16:00:00',
        'numeroPartecipanti' => 3,
        'postiDisponibili'   => 5,
        'postiRimanenti'     => 5,
        'hasPostiDisponibili'=> true,
        'tornei'             => [$torneo_figlio_senza_podio],
    ]),
    // Terminata, classifica NON ancora generata: un torneo ha podio, uno no -> avviso + pulsante disabilitato
    'terminato_non_generata' => array_merge($dettaglio_challenge_base, [
        'statoEvento'        => 'Terminato',
        'dataInizio'         => '2026-06-01 16:00:00',
        'numeroPartecipanti' => 8,
        'postiDisponibili'   => 0,
        'postiRimanenti'     => 0,
        'hasPostiDisponibili'=> false,
        'tornei'             => [$torneo_figlio_con_podio, $torneo_figlio_senza_podio],
        'classificaGenerata' => false,
        'torneiSenzaEsito'   => [
            ['id' => 306, 'nome' => 'Torneo Wingspan - Volo Libero'],
        ],
    ]),
    // Terminata, con TUTTI i tornei con podio -> pulsante "Genera classifica" attivo
    'terminato_pronta' => array_merge($dettaglio_challenge_base, [
        'idEvento'           => 505,
        'statoEvento'        => 'Terminato',
        'dataInizio'         => '2026-05-01 16:00:00',
        'numeroPartecipanti' => 8,
        'postiDisponibili'   => 0,
        'postiRimanenti'     => 0,
        'hasPostiDisponibili'=> false,
        'tornei'             => [$torneo_figlio_con_podio, array_merge($torneo_figlio_senza_podio, [
            'idEvento' => 307,
            'podio' => [
                ['posizione' => 1, 'utente' => ['id' => 5, 'nome' => 'Elena Ferrari']],
                ['posizione' => 2, 'utente' => ['id' => 6, 'nome' => 'Davide Romano']],
            ],
        ])],
        'classificaGenerata' => false,
        'torneiSenzaEsito'   => [],
    ]),
    // Terminata, classifica GIA' generata -> sola lettura
    'terminato_generata' => array_merge($dettaglio_challenge_base, [
        'idEvento'           => 502,
        'nomeEvento'         => 'Challenge Catan - Resa dei Conti',
        'statoEvento'        => 'Terminato',
        'dataInizio'         => '2026-02-14 18:00:00',
        'numeroPartecipanti' => 8,
        'postiDisponibili'   => 0,
        'postiRimanenti'     => 0,
        'hasPostiDisponibili'=> false,
        'tornei'             => [$torneo_figlio_con_podio],
        'classificaGenerata' => true,
        'classificaFinale' => [
            ['posizione' => 1, 'punteggioTotale' => 16, 'utente' => ['id' => 2, 'nome' => 'Giulia Verdi']],
            ['posizione' => 2, 'punteggioTotale' => 12, 'utente' => ['id' => 5, 'nome' => 'Elena Ferrari']],
            ['posizione' => 3, 'punteggioTotale' => 9,  'utente' => ['id' => 1, 'nome' => 'Marco Bianchi']],
            ['posizione' => 4, 'punteggioTotale' => 3,  'utente' => ['id' => 4, 'nome' => 'Sara Colombo']],
        ],
    ]),
];


// ══════════════════════════════════════════════════════════════
//  CAMBIA QUESTA RIGA PER TESTARE LE PAGINE:
//  LISTE:      'serate' | 'tornei' | 'challenge' | 'prodotti'
//  CREAZIONE:  'crea_serata' | 'crea_torneo' | 'crea_challenge'
//              | 'crea_gioco' | 'crea_bustine' | 'crea_portadadi'
//  DETTAGLIO SERATA:    'dett_serata:programmato_futura' | 'dett_serata:programmato_passata'
//                      | 'dett_serata:in_corso' | 'dett_serata:terminato' | 'dett_serata:annullato'
//  DETTAGLIO TORNEO:    'dett_torneo:programmato_futura' | 'dett_torneo:programmato_passata'
//                      | 'dett_torneo:in_corso' | 'dett_torneo:annullato'
//                      | 'dett_torneo:terminato_senza_podio' | 'dett_torneo:terminato_con_podio'
//  DETTAGLIO CHALLENGE: 'dett_challenge:programmato_futura' | 'dett_challenge:in_corso'
//                      | 'dett_challenge:annullato' | 'dett_challenge:terminato_non_generata'
//                      | 'dett_challenge:terminato_pronta' | 'dett_challenge:terminato_generata'
// ══════════════════════════════════════════════════════════════

$mappaVisteListe = [
    'serate'    => ['eventi' => $eventi_serate,    'template' => 'gestore_eventi_serate.tpl',    'page' => 'gestore_eventi_serate'],
    'tornei'    => ['eventi' => $eventi_tornei,    'template' => 'gestore_eventi_tornei.tpl',    'page' => 'gestore_eventi_tornei'],
    'challenge' => ['eventi' => $eventi_challenge, 'template' => 'gestore_eventi_challenge.tpl', 'page' => 'gestore_eventi_challenge'],
    'catalogo_gioco'     => ['prodotti' => array_values(array_filter($prodotti_gestore, fn($p) => $p['tipoSlug'] === 'giochi-da-tavolo')), 'template' => 'gestore_catalogo_gioco.tpl',     'page' => 'gestore_catalogo_gioco'],
    'catalogo_bustine'   => ['prodotti' => array_values(array_filter($prodotti_gestore, fn($p) => $p['tipoSlug'] === 'bustine')),          'template' => 'gestore_catalogo_bustine.tpl',   'page' => 'gestore_catalogo_bustine'],
    'catalogo_portadadi' => ['prodotti' => array_values(array_filter($prodotti_gestore, fn($p) => $p['tipoSlug'] === 'porta-dadi')),       'template' => 'gestore_catalogo_portadadi.tpl', 'page' => 'gestore_catalogo_portadadi'],
];

// ── Mappa delle pagine di DETTAGLIO evento (gestore) ──
$mappaVisteDettaglio = [
    'dett_serata'    => ['varianti' => $dettagli_serata,    'template' => 'gestore_dettaglio_serata.tpl',    'page' => 'gestore_dettaglio_serata'],
    'dett_torneo'    => ['varianti' => $dettagli_torneo,    'template' => 'gestore_dettaglio_torneo.tpl',    'page' => 'gestore_dettaglio_torneo'],
    'dett_challenge' => ['varianti' => $dettagli_challenge, 'template' => 'gestore_dettaglio_challenge.tpl', 'page' => 'gestore_dettaglio_challenge'],
];

$vistaCorrente = 'catalogo_gioco';// <-- CAMBIA QUI PER TESTARE LE PAGINE);

// ── DATI GLOBALI DI LAYOUT (richiesti da layout_gestore.tpl) ──
$smarty->assign('base_url', BASE_URL);
$smarty->assign('utente', ['name' => 'Marco Rossi']);

// Il breadcrumb qui è statico e generico: per le pagine di dettaglio, in produzione
// arriva da CGestore::getBreadcrumbs() (che usa $nomeEventoCorrente). Nel mock lo
// teniamo semplice, dato che serve solo a testare il resto della UI.
[$vistaBase] = explode(':', $vistaCorrente, 2);
$smarty->assign('breadcrumbs', [
    ['label' => 'Home', 'url' => BASE_URL . '/'],
    ['label' => 'Dashboard Gestore', 'url' => BASE_URL . '/gestore/dashboard'],
    ['label' => ucfirst($vistaBase), 'url' => BASE_URL . '/gestore/eventi/' . $vistaBase],
]);

// Facoltativo: per testare la flash message
// $smarty->assign('flash_message', 'Serata pubblicata con successo!');
// $smarty->assign('flash_type', 'success');


// ══════════════════════════════════════════════════════════════
//  MOCK DATI PER LE PAGINE DI CREAZIONE
// ══════════════════════════════════════════════════════════════

$premiDisponibili = [
    ['id' => 101, 'nome' => 'Catan',             'immagine' => BASE_URL . '/img/placeholder.jpg'],
    ['id' => 102, 'nome' => '7 Wonders',         'immagine' => BASE_URL . '/img/placeholder.jpg'],
    ['id' => 103, 'nome' => 'Carcassonne',       'immagine' => BASE_URL . '/img/placeholder.jpg'],
    ['id' => 104, 'nome' => 'Wingspan',          'immagine' => BASE_URL . '/img/placeholder.jpg'],
    ['id' => 105, 'nome' => 'Azul',              'immagine' => BASE_URL . '/img/placeholder.jpg'],
    ['id' => 106, 'nome' => 'Brass Birmingham',  'immagine' => BASE_URL . '/img/placeholder.jpg'],
];

$giochiDisponibili = [
    ['id' => 101, 'nome' => 'Catan',       'immagine' => BASE_URL . '/img/placeholder.jpg'],
    ['id' => 102, 'nome' => '7 Wonders',   'immagine' => BASE_URL . '/img/placeholder.jpg'],
    ['id' => 103, 'nome' => 'Carcassonne', 'immagine' => BASE_URL . '/img/placeholder.jpg'],
    ['id' => 104, 'nome' => 'Wingspan',    'immagine' => BASE_URL . '/img/placeholder.jpg'],
];

$torneiDisponibili = [
    ['idEvento' => 302, 'nomeEvento' => 'Torneo 7 Wonders - Sfida Estiva',         'imgEvento' => BASE_URL . '/img/placeholder.jpg', 'gioco' => '7 Wonders'],
    ['idEvento' => 303, 'nomeEvento' => 'Torneo Carcassonne - Edizione Invernale', 'imgEvento' => BASE_URL . '/img/placeholder.jpg', 'gioco' => 'Carcassonne'],
    ['idEvento' => 304, 'nomeEvento' => 'Torneo Azul - Notte Blu',                 'imgEvento' => BASE_URL . '/img/placeholder.jpg', 'gioco' => 'Azul'],
    ['idEvento' => 305, 'nomeEvento' => 'Torneo Brass - Sfida Industriale',        'imgEvento' => BASE_URL . '/img/placeholder.jpg', 'gioco' => 'Brass Birmingham'],
    ['idEvento' => 306, 'nomeEvento' => 'Torneo Wingspan - Volo Libero',           'imgEvento' => BASE_URL . '/img/placeholder.jpg', 'gioco' => 'Wingspan'],
];

$valute_enum = [
    ['value' => 'eur', 'label' => 'Euro (€)'],
    ['value' => 'usd', 'label' => 'Dollaro USA ($)'],
    ['value' => 'gbp', 'label' => 'Sterlina (£)'],
];

$mappaVisteCreazione = [
    'crea_serata'    => ['template' => 'gestore_creazione_serata.tpl',    'page' => 'gestore_creazione_serata'],
    'crea_torneo'    => ['template' => 'gestore_creazione_torneo.tpl',    'page' => 'gestore_creazione_torneo'],
    'crea_challenge' => ['template' => 'gestore_creazione_challenge.tpl', 'page' => 'gestore_creazione_challenge'],
    'crea_gioco'     => ['template' => 'gestore_creazione_gioco.tpl',     'page' => 'gestore_creazione_gioco'],
    'crea_bustine'   => ['template' => 'gestore_creazione_bustine.tpl',   'page' => 'gestore_creazione_bustine'],
    'crea_portadadi' => ['template' => 'gestore_creazione_portadadi.tpl', 'page' => 'gestore_creazione_portadadi'],
];


// ══════════════════════════════════════════════════════════════
//  SELEZIONE VISTA + ASSIGN + DISPLAY
// ══════════════════════════════════════════════════════════════

// $vistaCorrente per il dettaglio arriva nella forma "dett_serata:programmato_futura":
// separiamo la chiave base (per trovare template/pagina) dalla variante (per i dati).
[$vistaChiave, $vistaVariante] = array_pad(explode(':', $vistaCorrente, 2), 2, null);

if ($vistaCorrente === 'prodotti') {
    $smarty->assign('current_page', 'gestore_prodotti');

    $smarty->assign('prodotti', $prodotti_gestore);
    $smarty->assign('total_results', count($prodotti_gestore));
    $smarty->assign('pagination', [
        'current_page' => 1,
        'total_pages'  => 1,
    ]);

    $smarty->assign('filtri', [
        'q'                   => $_GET['q'] ?? null,
        'tipo_prodotto'       => $_GET['tipo_prodotto'] ?? [],
        'disponibilita'       => $_GET['disponibilita'] ?? [],
        'disponibilita_enum'  => $disponibilita_enum,
        'ordinamento'         => $_GET['ordinamento'] ?? null,
    ]);

    $smarty->assign('livelloDanno_enum', $livelloDanno_enum);

    $smarty->display('gestore_prodotti.tpl');

} elseif (isset($mappaVisteListe[$vistaCorrente])) {
    $vista = $mappaVisteListe[$vistaCorrente];

    $smarty->assign('current_page', $vista['page']);
    $smarty->assign('eventi', $vista['eventi'] ?? null);
    $smarty->assign('prodotti', $vista['prodotti'] ?? null);
    $smarty->assign('total_results', count($vista['eventi'] ?? $vista['prodotti'] ?? []));
    $smarty->assign('pagination', ['current_page' => 1, 'total_pages' => 1]);
    $smarty->assign('filtri', [
        'q'                  => $_GET['q'] ?? null,
        'data'               => $_GET['filtro_data'] ?? null,
        'disponibilita'      => $_GET['disponibilita'] ?? [],
        'disponibilita_enum' => $disponibilita_enum,
        'ordinamento'        => $_GET['ordinamento'] ?? null,
    ]);
    $smarty->assign('livelloDanno_enum', $livelloDanno_enum);

    $smarty->display($vista['template']);

} elseif (isset($mappaVisteDettaglio[$vistaChiave])) {
    $vista = $mappaVisteDettaglio[$vistaChiave];

    if ($vistaVariante === null || !isset($vista['varianti'][$vistaVariante])) {
        die("Variante di dettaglio non riconosciuta. Usa il formato 'chiave:variante', es. 'dett_torneo:terminato_con_podio'. Varianti disponibili per '$vistaChiave': " . implode(', ', array_keys($vista['varianti'])));
    }

    $datiEvento = $vista['varianti'][$vistaVariante];

    $smarty->assign('current_page', $vista['page']);
    // Assegniamo ogni chiave del mock direttamente come variabile di root, esattamente
    // come fa preparaDatiLayout() con array_merge($globalData, $data) nel controller reale.
    foreach ($datiEvento as $chiave => $valore) {
        $smarty->assign($chiave, $valore);
    }

    $smarty->display($vista['template']);

} elseif (isset($mappaVisteCreazione[$vistaCorrente])) {
    $vista = $mappaVisteCreazione[$vistaCorrente];

    $smarty->assign('current_page', $vista['page']);
    $smarty->assign('premiDisponibili', $premiDisponibili);
    $smarty->assign('giochiDisponibili', $giochiDisponibili);
    $smarty->assign('torneiDisponibili', $torneiDisponibili);
    $smarty->assign('valute_enum', $valute_enum);

    $smarty->display($vista['template']);

} else {
    die("Vista '$vistaCorrente' non riconosciuta.");
}

/*

//administratore
$smarty->assign('annoCorrente', date('Y'));

// ── DATI ADMIN ──
$smarty->assign('admin', [
    'nome'      => 'Admin User',
    'ruolo'     => 'Amministratore',
    'avatarUrl' => null,
]);
$smarty->assign('notificheNonLette', 3);
$smarty->assign('segnalazioniInAttesaCount', 2);
$smarty->assign('activeNav', 'dashboard');
$smarty->assign('pageTitle', 'Dashboard');

// ── DATI DASHBOARD (mock, struttura conforme a CAmministratore::mostraDashboardAdmin) ──
$smarty->assign('segnalazioniInSospeso', 12);
$smarty->assign('utentiTotali', 1245);
$smarty->assign('utentiNuoviOggi', 18);
$smarty->assign('utentiSospesiTotali', 8);
$smarty->assign('utentiSospesiOggi', 0);

$segnalazioniUrgenti = [
    [
        'id' => 1,
        'data' => '2026-07-17 09:15:00',
        'stato' => 'in_sospeso',
        'motivazione' => ['id' => 1, 'nome' => 'Contenuto offensivo', 'gravita' => 'alta'],
        'utenteSegnalante' => ['id' => 5, 'nome' => 'Marco92'],
        'autoreRecensione' => ['id' => 9, 'nome' => 'XxGamerxX'],
        'prodotto' => ['id' => 101, 'nome' => 'Catan'],
    ],
    [
        'id' => 2,
        'data' => '2026-07-16 18:40:00',
        'stato' => 'in_sospeso',
        'motivazione' => ['id' => 2, 'nome' => 'Spam', 'gravita' => 'media'],
        'utenteSegnalante' => ['id' => 6, 'nome' => 'GiulyGamer'],
        'autoreRecensione' => ['id' => 22, 'nome' => 'ProPlayer99'],
        'prodotto' => ['id' => 202, 'nome' => 'Azul'],
    ],
];
  


$recensioniMock = [
    [
        'id' => 101,
        'testo' => 'Prodotto arrivato rotto, pessima qualità del materiale e servizio clienti inesistente.',
        'data' => '2026-07-16 18:42:00',
        'gravita' => 'alta',
        'idSegnalazioneDaRisolvere' => 501,
        'autore' => ['id' => 12, 'nome' => 'XxGamerxX'],
        'prodotto' => ['id' => 33, 'nome' => 'Catan'],
        'numeroSegnalazioni' => 4,
    ],
    [
        'id' => 102,
        'testo' => 'Recensione con linguaggio scorretto verso altri utenti nei commenti.',
        'data' => '2026-07-17 09:15:00',
        'gravita' => 'media',
        'idSegnalazioneDaRisolvere' => 502,
        'autore' => ['id' => 27, 'nome' => 'Marco92'],
        'prodotto' => ['id' => 41, 'nome' => 'Carcassonne'],
        'numeroSegnalazioni' => 2,
    ],
    [
        'id' => 103,
        'testo' => 'Recensione poco pertinente, sembra più uno spam pubblicitario che un giudizio sul prodotto.',
        'data' => '2026-07-14 12:03:00',
        'gravita' => 'bassa',
        'idSegnalazioneDaRisolvere' => 503,
        'autore' => ['id' => 8, 'nome' => 'BoardFan99'],
        'prodotto' => ['id' => 19, 'nome' => 'Ticket to Ride'],
        'numeroSegnalazioni' => 1,
    ],
];


$utentiMock = [
    [
        'id' => 12,
        'nome' => 'Luca Verdi',
        'stato' => 'attivo',
        'numeroSegnalazioni' => 4,
    ],
    [
        'id' => 15,
        'nome' => 'Anna Neri',
        'stato' => 'sospeso',
        'numeroSegnalazioni' => 2,
    ],
    [
        'id' => 9,
        'nome' => 'Giulia Rossi',
        'stato' => 'attivo',
        'numeroSegnalazioni' => 1,
    ],
    [
        'id' => 33,
        'nome' => 'Paolo Blu',
        'stato' => 'bannato',
        'numeroSegnalazioni' => 6,
    ],
];
// ── base_url mancante prima della display ──
$smarty->assign('base_url', BASE_URL);

// ── MOCK UTENTE SINGOLO (per dettagli_utente_admin.tpl) ──
// Simula l'entity EUtente: il tpl chiama getIdPersona(), getNomePersona(), getStato()->value
class MockUtenteAdmin {
    public function __construct(
        private int $id,
        private string $nome,
        private object $stato
    ) {}
    public function getIdPersona(): int { return $this->id; }
    public function getNomePersona(): string { return $this->nome; }
    public function getStato(): object { return $this->stato; }
}

$statoMock = new class('attivo') {
    public function __construct(public string $value) {}
};

$utenteDettaglio = new MockUtenteAdmin(12, 'Luca Verdi', $statoMock);
$smarty->assign('utente', $utenteDettaglio);

// ── MOCK RECENSIONI DELL'UTENTE (struttura conforme a BaseController::recensioniToArray) ──
$recensioniUtenteDettaglio = [
    [
        'id' => 101,
        'valutazione' => 2,
        'testo' => 'Prodotto arrivato rotto, pessima qualità del materiale e servizio clienti inesistente.',
        'data' => '16/07/2026',
        'id_utente' => 12,
        'utente' => 'Luca Verdi',
        'id_segnalazione' => 501, // vedi nota sotto
        'prodotto' => [
            'id' => 33,
            'nome' => 'Catan',
            'immagine' => 'placeholder.jpg',
        ],
    ],
    [
        'id' => 104,
        'valutazione' => 3,
        'testo' => "Recensione nella media, niente di che.",
        'data' => '02/07/2026',
        'id_utente' => 12,
        'utente' => 'Luca Verdi',
        'id_segnalazione' => 507,
        'prodotto' => [
            'id' => 41,
            'nome' => 'Carcassonne',
            'immagine' => 'placeholder.jpg',
        ],
    ],
];





$smarty->assign('recensioniSegnalate', $recensioniUtenteDettaglio);

$smarty->assign('utenti', $utentiMock);

$smarty->assign('activeNav', 'segnalazioni');
$smarty->assign('segnalazioniInAttesaCount', count($recensioniMock));
$smarty->assign('annoCorrente', date('Y'));

// Dati specifici della pagina
$smarty->assign('recensioni', $recensioniMock);
$smarty->assign('ordinamento', 'recenti');

$smarty->assign('segnalazioniUrgenti', $segnalazioniUrgenti);








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

*/


