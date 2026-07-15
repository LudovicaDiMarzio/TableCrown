<?php
// Presentation/Views/ViewProfiloIndirizzi.php

namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

class ViewProfiloIndirizzi extends ViewProfiloBase {

    public static function mostraProfiloIndirizzi(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        self::assegnaGlobali($smarty, $dati, 'profilo-indirizzi');

        // --- Dati specifici della pagina indirizzi ---
        $smarty->assign('indirizzi', $dati['indirizzi'] ?? []);

        $smarty->display('ProfiloIndirizzi.tpl');
    }
}