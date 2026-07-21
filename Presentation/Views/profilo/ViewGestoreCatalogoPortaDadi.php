<?php
namespace TableCrown\Presentation\Views;

class ViewGestoreCatalogoPortaDadi extends BaseViewGestore {
    protected function getTemplateName(array $dati): string {
        return 'gestore_catalogo_portadadi.tpl';
    }
}