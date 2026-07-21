<?php
// Presentation/Views/ViewProdotto.php

namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

class ViewProdotto {

    /**
     * Esegue gli assign per la pagina di dettaglio prodotto e il display del template.
     * $dati è l'array prodotto da CProdotto::mostraDettaglioProdotto() dopo preparaDatiLayout().
     */
    public static function mostraDettaglioProdotto(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        // --- Dati globali di layout ---
        $smarty->assign('base_url',     $dati['base_url'] ?? '');
        $smarty->assign('current_page', $dati['current_page'] ?? 'prodotto');
        $smarty->assign('breadcrumbs',  $dati['breadcrumbs'] ?? []);
        $smarty->assign('utente',       $dati['utente'] ?? null);
        $smarty->assign('cart_count',   $dati['cart_count'] ?? 0);

        if (isset($dati['flash_message'])) {
            $smarty->assign('flash_message', $dati['flash_message']);
            $smarty->assign('flash_type', $dati['flash_type']);
        }

        // --- Dati comuni del prodotto (chiavi di prodottoToArray(), NON rinominate) ---
        $smarty->assign('id',                 $dati['id'] ?? null);
        $smarty->assign('nome',               $dati['nome'] ?? '');
        $smarty->assign('immagine',           $dati['immagine'] ?? null);
        $smarty->assign('valutazione_media',  $dati['valutazione_media'] ?? 0.0);
        $smarty->assign('prezzo',             $dati['prezzo'] ?? null);
        $smarty->assign('sconto',             $dati['sconto'] ?? false);
        $smarty->assign('prezzo_scontato',    $dati['prezzo_scontato'] ?? null);
        $smarty->assign('percentuale_sconto', $dati['percentuale_sconto'] ?? null);
        $smarty->assign('disponibilita',      $dati['disponibilita'] ?? null);
       $smarty->assign('userHasPurchased',    $dati['userHasPurchased'] ?? false);
        $smarty->assign('puoRecensire',        $dati['puoRecensire'] ?? false);

        // --- Campi esclusivi della pagina di dettaglio ---
        $smarty->assign('descrizioneProdotto', $dati['descrizioneProdotto'] ?? '');
        $smarty->assign('quantita',            $dati['quantita'] ?? 0);
        $smarty->assign('dataPubblicazione',   $dati['dataPubblicazione'] ?? null);
        $smarty->assign('recensioni',          $dati['recensioni'] ?? []);
        $smarty->assign('correlati',           $dati['correlati'] ?? []);
        $smarty->assign('userHasPurchased',    $dati['userHasPurchased'] ?? false);
        $smarty->assign('isInWishlist',        $dati['isInWishlist'] ?? false);
        $smarty->assign('motivazioni',         $dati['motivazioni'] ?? []);

        // --- Campi specifici solo per EGiocoDaTavolo (assenti per EBustine/EPortaDadi) ---
        $smarty->assign('categoria',          $dati['categoria'] ?? null);
        $smarty->assign('componenti',         $dati['componenti'] ?? null);
        $smarty->assign('giocoBase',          $dati['giocoBase'] ?? null);
        $smarty->assign('numeroGiocatoriMin', $dati['numeroGiocatoriMin'] ?? null);
        $smarty->assign('numeroGiocatoriMax', $dati['numeroGiocatoriMax'] ?? null);
        $smarty->assign('etaMinima',          $dati['etaMinima'] ?? null);
        $smarty->assign('durataMedia',        $dati['durataMedia'] ?? null);
        $smarty->assign('danno',              $dati['danno'] ?? null);
        $smarty->assign('descrizioneDanno',   $dati['descrizioneDanno'] ?? null);
        $smarty->assign('lingua',             $dati['lingua'] ?? null);
        $smarty->assign('difficolta',         $dati['difficolta'] ?? null);

        $smarty->display('prodotto.tpl');
    }
}