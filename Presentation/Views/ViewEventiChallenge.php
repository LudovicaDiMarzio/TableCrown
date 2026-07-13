<?php
// Presentation/Views/ViewEventiChallenge.php
namespace TableCrown\Presentation\Views;

class ViewEventiChallenge extends BaseViewEventi {
    private const TEMPLATE = 'eventi/catalogo_challenge.tpl';

    public function render(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();
        $this->assegnaDati($smarty, $dati);
        $smarty->display(self::TEMPLATE);
    }
}