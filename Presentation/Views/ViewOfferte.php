<?php
// Presentation/Views/ViewOfferte.php
namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

class ViewOfferte extends BaseViewCatalogo {
    private const TEMPLATE = 'catalogo/CatalogoOfferte.tpl';

    public function render(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();
        $this->assegnaDati($smarty, $dati);
        $smarty->display(self::TEMPLATE);
    }
}