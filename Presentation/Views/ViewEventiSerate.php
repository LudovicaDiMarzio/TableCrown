<?php
// Presentation/Views/ViewEventiSerate.php
namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

class ViewEventiSerate extends BaseViewEventi {
    private const TEMPLATE = 'catalogo_serate.tpl';

    public function render(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();
        $this->assegnaDati($smarty, $dati);
        $smarty->display(self::TEMPLATE);
    }
}