<?php
namespace TableCrown\Presentation\Views;

class ViewGestoreDettaglioSerata extends BaseViewGestore {
    protected function getTemplateName(array $dati): string {
        return 'gestore_dettaglio_serata.tpl';
    }

}