<?php
namespace TableCrown\Presentation\Views;

class ViewGestoreCreazioneTorneo extends BaseViewGestore {

    protected function getTemplateName(array $dati): string {
        return 'gestore_creazione_torneo.tpl';
    }
}