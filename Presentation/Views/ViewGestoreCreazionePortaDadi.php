<?php
namespace TableCrown\Presentation\Views;

class ViewGestoreCreazionePortaDadi extends BaseViewGestore {

    protected function getTemplateName(array $dati): string {
        return 'gestore_creazione_portadadi.tpl';
    }
}