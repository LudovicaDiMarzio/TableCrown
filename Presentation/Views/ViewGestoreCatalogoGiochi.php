<?php
namespace TableCrown\Presentation\Views;

class ViewGestoreCatalogoGiochi extends BaseViewGestore {
    protected function getTemplateName(array $dati): string {
        return 'gestore_catalogo_gioco.tpl';
    }
}