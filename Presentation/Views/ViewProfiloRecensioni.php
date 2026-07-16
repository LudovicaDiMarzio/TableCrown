<?php
// Presentation/Views/ViewProfiloRecensioni.php

namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

class ViewProfiloRecensioni extends ViewProfiloBase {

    public static function mostraProfiloRecensioni(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        self::assegnaGlobali($smarty, $dati, 'profilo-recensioni');

        // --- Dati specifici della pagina recensioni ---
        // 'recensioni' con: id, valutazione, testo, data, prodotto{id,nome,immagine}, isSegnalata
        $smarty->assign('recensioni', $dati['recensioni'] ?? []);

        $smarty->display('MieRecensioni.tpl');
    }
}