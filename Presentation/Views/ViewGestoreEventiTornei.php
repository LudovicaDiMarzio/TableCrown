<?php
namespace TableCrown\Presentation\Views;

class ViewGestoreEventiTornei extends BaseViewGestore {
    protected function getTemplateName(array $dati): string {
        return 'gestore_eventi_tornei.tpl';
    }

}