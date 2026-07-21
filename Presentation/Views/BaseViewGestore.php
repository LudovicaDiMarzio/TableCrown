<?php
/**
 * Base astratta per tutte le View dell'area Gestore.
 * Centralizza l'istanziazione di Smarty e l'assegnazione dei dati,
 * lasciando alle sottoclassi solo la scelta del template da mostrare.
 */
namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

abstract class BaseViewGestore implements ViewGestoreInterface {

    public function render(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        foreach ($dati as $chiave => $valore) {
            $smarty->assign($chiave, $valore);
        }
        $smarty->display($this->getTemplateName($dati));
    }

    /**
     * Ogni View concreta indica il nome del file .tpl da mostrare.
     * Riceve $dati per i (rari) casi in cui il template dipenda da una condizione
     * (qui non serve, ma manteniamo la firma coerente con BaseViewCatalogo/BaseViewEventi).
     */
    abstract protected function getTemplateName(array $dati): string;
}