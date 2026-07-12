<?php
// Presentation/Views/ViewProdotto.php

require_once __DIR__ . '/SmartyConfiguration.php';

class ViewProdotto {

    /**
     * Esegue gli assign per la pagina di dettaglio prodotto e il display del template.
     * $dati è l'array prodotto da CProdotto::mostraDettaglioProdotto() dopo preparaDatiLayout()
     * (preparaDatiLayout NON viene ancora chiamato nel controller attuale: va aggiunto).
     */
    public static function mostraDettaglioProdotto(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        // --- Dati globali di layout (richiedono che il controller chiami preparaDatiLayout) ---
        $smarty->assign('base_url',     $dati['base_url'] ?? '');
        $smarty->assign('current_page', $dati['current_page'] ?? 'prodotto');
        $smarty->assign('breadcrumbs',  $dati['breadcrumbs'] ?? []);
        $smarty->assign('utente',       $dati['utente'] ?? null);
        $smarty->assign('cart_count',   $dati['cart_count'] ?? 0);

        if (isset($dati['flash_message'])) {
            $smarty->assign('flash_message', $dati['flash_message']);
            $smarty->assign('flash_type', $dati['flash_type']);
        }

        // --- Dati specifici del prodotto ---
        // NOTA: qui assegno i campi così come oggi li produce costruisciDatiVista()
        // (piatti, non annidati sotto 'prodotto'). Se preferite annidarli sotto
        // $prodotto.* nel tpl, va cambiato il controller per fare
        // $dati['prodotto'] = [...] invece di un array piatto.
        $smarty->assign('idProdotto',           $dati['idProdotto'] ?? null);
        $smarty->assign('nomeProdotto',         $dati['nomeProdotto'] ?? '');
        $smarty->assign('imgProdotto',          $dati['imgProdotto'] ?? null);
        $smarty->assign('descrizioneProdotto',  $dati['descrizioneProdotto'] ?? '');
        $smarty->assign('disponibilitaProdotto',$dati['disponibilitaProdotto'] ?? null);
        $smarty->assign('quantita',             $dati['quantita'] ?? 0);
        $smarty->assign('dataPubblicazione',    $dati['dataPubblicazione'] ?? null);
        $smarty->assign('prezzo',               $dati['prezzo'] ?? null);
        $smarty->assign('valutazioneMedia',     $dati['valutazioneMedia'] ?? 0.0);
        $smarty->assign('recensioni',           $dati['recensioni'] ?? []);

        // --- Campi specifici solo per EGiocoDaTavolo (assenti per EBustine/EPortaDadi) ---
        $smarty->assign('categoria',           $dati['categoria'] ?? null);
        $smarty->assign('componenti',          $dati['componenti'] ?? null);
        $smarty->assign('giocoBase',           $dati['giocoBase'] ?? null);
        $smarty->assign('numeroGiocatoriMin',  $dati['numeroGiocatoriMin'] ?? null);
        $smarty->assign('numeroGiocatoriMax',  $dati['numeroGiocatoriMax'] ?? null);
        $smarty->assign('etaMinima',           $dati['etaMinima'] ?? null);
        $smarty->assign('durataMedia',         $dati['durataMedia'] ?? null);
        $smarty->assign('danno',               $dati['danno'] ?? null);
        $smarty->assign('descrizioneDanno',    $dati['descrizioneDanno'] ?? null);
        $smarty->assign('lingua',              $dati['lingua'] ?? null);
        $smarty->assign('difficolta',          $dati['difficolta'] ?? null);

        // --- Altri dati pagina ---
        $smarty->assign('correlati',        $dati['correlati'] ?? []);
        $smarty->assign('userHasPurchased', $dati['userHasPurchased'] ?? false);

        $smarty->display('prodotto.tpl');
    }
}