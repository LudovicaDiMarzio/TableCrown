<?php
namespace TableCrown\Presentation\Views;

class ViewGestoreCreazioneBustine extends BaseViewGestore {

    protected function getTemplateName(array $dati): string {
        return 'gestore_creazione_bustine.tpl';
    }
}