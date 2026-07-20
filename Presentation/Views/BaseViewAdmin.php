<?php
namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

/**
 * Classe astratta che centralizza la logica comune a tutte le View
 * dell'area amministratore (recupero istanza Smarty, assign, display).
 */
abstract class BaseViewAdmin implements ViewAdminInterface {

    /**
     * Nome del file .tpl da renderizzare, definito da ogni classe concreta.
     */
    protected const TEMPLATE = '';

    /**
     * Esegue l'assign dell'intero array di dati e il display del template.
     * Le classi concrete possono fare l'override se serve una logica di
     * assign più specifica (es. assign singoli invece che in blocco).
     */
    public function mostra(array $data): void {
        $smarty = SmartyConfiguration::getSmarty();

        foreach ($data as $chiave => $valore) {
            $smarty->assign($chiave, $valore);
        }

        $smarty->display(static::TEMPLATE);
    }
}