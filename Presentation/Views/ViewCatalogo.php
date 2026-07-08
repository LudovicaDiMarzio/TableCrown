<?php
// Presentation/Views/ViewCatalogo.php

require_once __DIR__ . '/SmartyConfiguration.php';

class ViewCatalogo {

    /**
     * Esegue gli assign comuni a tutte le pagine del catalogo (giochi da tavolo,
     * bustine, porta dadi, risultati ricerca) e il display del template corretto.
     *
     * $dati è l'array prodotto da preparaDatiLayout($nomeVista, $datiPagina)
     * dentro CCatalogo. Si assume che preparaDatiLayout inserisca la chiave
     * 'vista' con il nome passato come primo argomento (es. 'catalogo_bustine'):
     * è quella chiave che qui decide quale .tpl mostrare.
     */
    public static function render(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        // --- Dati globali di layout ---
        $smarty->assign('base_url',     $dati['base_url'] ?? '');
        $smarty->assign('current_page', $dati['current_page'] ?? 'catalogo');
        $smarty->assign('breadcrumbs',  $dati['breadcrumbs'] ?? []);
        $smarty->assign('utente',       $dati['utente'] ?? null);
        $smarty->assign('cart_count',   $dati['cart_count'] ?? 0);

        if (isset($dati['flash_message'])) {
            $smarty->assign('flash_message', $dati['flash_message']);
            $smarty->assign('flash_type', $dati['flash_type']);
        }

        // --- Dati comuni a tutte le pagine del catalogo ---
        $prodotti = $dati['prodotti'] ?? [];
        $smarty->assign('prodotti', $prodotti);
        $smarty->assign('total_results', $dati['totale_risultati'] ?? count($prodotti));

        $smarty->assign('pagination', [
            'current_page' => $dati['pagina'] ?? 1,
            'total_pages'  => $dati['totale_pagine'] ?? 0,
        ]);

        // --- Filtri: struttura piatta condivisa da bustine.tpl / portadadi.tpl ---
        $filtri = $dati['filtri'] ?? [];

        $smarty->assign('search_query',       $filtri['q'] ?? null);
        $smarty->assign('ordinamento',        $filtri['ordinamento'] ?? null);

        $smarty->assign('price_min',          $filtri['price_min'] ?? null);
        $smarty->assign('price_max',          $filtri['price_max'] ?? null);
        // Estremi assoluti dello slider prezzo (min/max disponibili nel catalogo),
        // non i valori scelti dall'utente: da popolare quando FPersistentManager
        // li fornirà; per ora default fissi.
        $smarty->assign('price_range_min',    $dati['price_range_min'] ?? 0);
        $smarty->assign('price_range_max',    $dati['price_range_max'] ?? 200);

        $smarty->assign('disponibilita',      $filtri['disponibilita'] ?? []);
        $smarty->assign('in_evidenza_filtro', $filtri['in_evidenza'] ?? []);
        $smarty->assign('rating_min',         $filtri['rating_min'] ?? null);

        // --- Dati specifici della vista "catalogo_giochi" ---
        if (isset($dati['categorie'])) {
            $smarty->assign('categorie', $dati['categorie']);
        }

        // --- Selezione del template in base alla vista richiesta dal controller ---
        $nomeVista = $dati['vista'] ?? 'catalogo_giochi';

        $templatePerVista = [
            'catalogo_giochi'    => 'GiochiDaTavolo.tpl',
            'catalogo_bustine'   => 'bustine.tpl',
            'catalogo_portadadi' => 'portadadi.tpl',
            'ricerca'            => 'ricerca.tpl',
        ];

        $template = $templatePerVista[$nomeVista] ?? 'GiochiDaTavolo.tpl';

        $smarty->display($template);
    }
}