<?php
// Presentation/Views/ViewGiochiDaTavolo.php
namespace TableCrown\Presentation\Views;

class ViewGiochiDaTavolo extends BaseViewCatalogo {
    private const TEMPLATE = 'catalogo/giochi_da_tavolo.tpl';

    public function render(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();
        $this->assegnaDati($smarty, $dati);
        $smarty->display(self::TEMPLATE);
    }
}