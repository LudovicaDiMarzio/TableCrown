<?php
// Presentation/Views/BaseViewCatalogo.php
namespace TableCrown\Presentation\Views;

use Smarty\Smarty;

abstract class BaseViewCatalogo implements ViewCatalogoInterface {

    protected function assegnaDati(Smarty $smarty, array $dati): void {
        foreach ($dati as $chiave => $valore) {
            if ($chiave === 'vista') {
                continue;
            }
            $smarty->assign($chiave, $valore);
        }
    }
}