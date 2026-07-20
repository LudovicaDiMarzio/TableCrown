<?php
namespace TableCrown\Presentation\Views;

class ViewGestoreCreazioneSerata extends BaseViewGestore {

    protected function getTemplateName(array $dati): string {
        return 'gestore_creazione_serata.tpl';
    }
}