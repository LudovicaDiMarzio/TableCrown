<?php
/**
 * Base astratta per tutte le View dell'area Gestore.
 * Centralizza l'istanziazione di Smarty e l'assegnazione dei dati,
 * lasciando alle sottoclassi solo la scelta del template da mostrare.
 */
namespace TableCrown\Presentation\Views;

use Smarty\Smarty;

abstract class BaseViewGestore implements ViewGestoreInterface {

    protected Smarty $smarty;

    public function __construct() {
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(__DIR__ . '/../templates/');
        $this->smarty->setCompileDir(__DIR__ . '/../templates_c/');
        //NOTA: percorsi da allineare a quelli usati in BaseViewAdmin/BaseViewCatalogo/BaseViewEventi,
        //non avendone il codice sotto mano ho mantenuto la stessa convenzione ipotizzata lì.
    }

    public function render(array $dati): void {
        foreach ($dati as $chiave => $valore) {
            $this->smarty->assign($chiave, $valore);
        }
        $this->smarty->display($this->getTemplateName($dati));
    }

    /**
     * Ogni View concreta indica il nome del file .tpl da mostrare.
     * Riceve $dati per i (rari) casi in cui il template dipenda da una condizione
     * (qui non serve, ma manteniamo la firma coerente con BaseViewCatalogo/BaseViewEventi).
     */
    abstract protected function getTemplateName(array $dati): string;
}