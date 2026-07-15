<?php
// Presentation/Views/ViewProfiloEventi.php

namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

class ViewProfiloEventi extends ViewProfiloBase {

    public static function mostraProfiloEventi(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        self::assegnaGlobali($smarty, $dati, 'profilo-eventi');

        // --- Dati specifici della pagina eventi ---
        $smarty->assign('eventi', $dati['eventi'] ?? []);
        $smarty->assign('ordinamento', $dati['ordinamento'] ?? 'futuri');

        $smarty->display('ProfiloEventi.tpl');
    }
}