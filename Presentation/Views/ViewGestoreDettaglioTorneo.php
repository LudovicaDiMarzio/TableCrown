<?php

namespace TableCrown\Presentation\Views;

class ViewGestoreDettaglioTorneo extends BaseViewGestore {
    protected function getTemplateName(array $dati): string {
        return 'gestore_dettaglio_torneo.tpl';
    }

}