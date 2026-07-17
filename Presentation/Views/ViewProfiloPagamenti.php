<?php
// Presentation/Views/ViewProfiloPagamenti.php

namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

class ViewProfiloPagamenti extends ViewProfiloBase {

    public static function mostraProfiloPagamenti(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        self::assegnaGlobali($smarty, $dati, 'profilo-pagamenti');

        // --- Dati specifici della pagina metodi di pagamento ---
        $smarty->assign('metodi', $dati['metodi'] ?? []);

        $smarty->display('ProfiloPagamenti.tpl');
    }
}