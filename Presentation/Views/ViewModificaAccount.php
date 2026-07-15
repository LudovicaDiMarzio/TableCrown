<?php
// Presentation/Views/ViewModificaAccount.php

namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

class ViewModificaAccount extends ViewProfiloBase {

    public static function mostraModificaAccount(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        self::assegnaGlobali($smarty, $dati, 'profilo-account');

        // --- Dati specifici della pagina modifica account ---
        // Nomi variabili FISSATI come da accordo: dati piatti, NON un array 'utente' annidato.
        $smarty->assign('nomeUtente', $dati['nomeUtente']);
        $smarty->assign('emailUtente', $dati['emailUtente']);
        $smarty->assign('immagineUtente', $dati['immagineUtente'] ?? null);
        $smarty->assign('etaUtente', $dati['etaUtente']);

        // Cambio password ed eliminazione account sono gestiti via AJAX
        // (endpoint /account/password e /account/elimina) e non richiedono
        // ulteriori variabili qui.

        $smarty->display('ModificaAccount.tpl');
    }
}