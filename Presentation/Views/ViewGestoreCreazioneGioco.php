<?php
namespace TableCrown\Presentation\Views;

class ViewGestoreCreazioneGioco extends BaseViewGestore {

    protected function getTemplateName(array $dati): string {
        return 'gestore_creazione_gioco.tpl';
    }
}
