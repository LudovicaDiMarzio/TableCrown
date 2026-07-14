<?php
// Presentation/Views/BaseViewEventi.php
namespace TableCrown\Presentation\Views;

use Smarty\Smarty;

abstract class BaseViewEventi implements ViewEventiInterface {

    protected function assegnaDati(Smarty $smarty, array $dati): void {
        foreach ($dati as $chiave => $valore) {
            if ($chiave === 'vista') {
                continue;
            }
            $smarty->assign($chiave, $valore);
        }
    }
}