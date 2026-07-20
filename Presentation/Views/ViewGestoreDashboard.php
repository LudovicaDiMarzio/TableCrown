<?php
namespace TableCrown\Presentation\Views;

class ViewGestoreDashboard extends BaseViewGestore {

    protected function getTemplateName(array $dati): string {
        return 'gestore_dashboard.tpl';
    }
}
