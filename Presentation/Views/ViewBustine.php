<?php
// Presentation/Views/ViewBustine.php
namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

class ViewBustine extends BaseViewCatalogo {
    private const TEMPLATE = 'catalogo/bustine.tpl';

    public function render(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();
        $this->assegnaDati($smarty, $dati);
        $smarty->display(self::TEMPLATE);
    }
}