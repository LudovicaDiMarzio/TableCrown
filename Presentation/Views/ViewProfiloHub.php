<?php
// Presentation/Views/ViewProfiloHub.php

namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

class ViewProfiloHub extends ViewProfiloBase {

    public static function mostraProfiloHub(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        self::assegnaGlobali($smarty, $dati, 'profilo-hub');

        // --- Dati specifici della pagina hub ---
        $smarty->assign('nomeUtente', $dati['nomeUtente']);
        $smarty->assign('immagineUtente', $dati['immagineUtente'] ?? null);
        $smarty->assign('torneiVinti', $dati['torneiVinti']);
        $smarty->assign('torneiTotali', $dati['torneiTotali']);
        $smarty->assign('playerLevel', $dati['playerLevel']);
        $smarty->assign('livelloSuccessivo', $dati['livelloSuccessivo'] ?? null);
        $smarty->assign('torneiMancanti', $dati['torneiMancanti'] ?? null);

        // 'menuVoci' è statico lato Presentation: non dipende dal Control.
        // Se preferite generarlo lato Control (es. per permessi dinamici),
        // sostituite questa riga con: $smarty->assign('menuVoci', $dati['menuVoci']);
        $smarty->assign('account_menu', $dati['menuVoci'] ?? []);
        $smarty->assign('tornei_vinti', $dati['torneiVinti']);
        $smarty->assign('tornei_obiettivo', $dati['torneiTotali']);

        $smarty->display('AreaPersonale.tpl');
    }
}