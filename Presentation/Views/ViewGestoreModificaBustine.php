<?php
namespace TableCrown\Presentation\Views;

class ViewGestoreModificaBustine extends BaseViewGestore {
    protected function getTemplateName(array $dati): string {
        return 'gestore_modifica_bustine.tpl';
    }
}