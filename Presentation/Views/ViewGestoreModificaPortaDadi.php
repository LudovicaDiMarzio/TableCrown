<?php
namespace TableCrown\Presentation\Views;

class ViewGestoreModificaPortaDadi extends BaseViewGestore {
    protected function getTemplateName(array $dati): string {
        return 'gestore_modifica_portadadi.tpl';
    }
}