<?php
// Presentation/Views/ViewEventiTornei.php
namespace TableCrown\Presentation\Views;

class ViewEventiTornei extends BaseViewEventi {
    private const TEMPLATE = 'eventi/catalogo_tornei.tpl';

    public function render(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();
        $this->assegnaDati($smarty, $dati);
        $smarty->display(self::TEMPLATE);
    }
}