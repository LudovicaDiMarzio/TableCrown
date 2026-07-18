<?php
// Presentation/Views/ViewEventiHome.php
namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

class ViewEventiHome extends BaseViewEventi {
    private const TEMPLATE = 'eventi.tpl';

    public function render(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();
        $this->assegnaDati($smarty, $dati);
        $smarty->display(self::TEMPLATE);
    }
}