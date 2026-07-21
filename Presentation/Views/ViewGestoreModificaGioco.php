<?php
namespace TableCrown\Presentation\Views;

class ViewGestoreModificaGioco extends BaseViewGestore {
    protected function getTemplateName(array $dati): string {
        return 'gestore_modifica_gioco.tpl';
    }
}