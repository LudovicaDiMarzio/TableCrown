<?php
// Presentation/Views/ViewPortaDadi.php
namespace TableCrown\Presentation\Views;

use SmartyConfiguration;


class ViewPortaDadi extends BaseViewCatalogo {
    private const TEMPLATE = 'catalogo/portadadi.tpl';

    public function render(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();
        $this->assegnaDati($smarty, $dati);
        $smarty->display(self::TEMPLATE);
    }
}