<?php
namespace TableCrown\Presentation\Views;

/**
 * View incaricata di renderizzare la pagina di checkout, condivisa sia dal flusso
 * di acquisto prodotti (CCheckout) sia dal flusso di iscrizione eventi (CDettaglioEvento).
 * A differenza di ViewCatalogo/ViewEventi non serve un dispatcher su più template:
 * esiste un solo checkout.tpl, il cui contenuto viene diversificato in base al
 * flag 'tipo_checkout' già presente nell'array $dati preparato dal controller.
 */
class ViewCheckout {

    /**
     * Renderizza checkout.tpl con i dati preparati dal controller
     * (già passati da preparaDatiLayout(), quindi comprensivi dei dati globali di layout).
     */
    public static function mostraCheckout(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        foreach ($dati as $chiave => $valore) {
            $smarty->assign($chiave, $valore);
        }

        $smarty->display('checkout.tpl');
    }
}