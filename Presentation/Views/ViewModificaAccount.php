<?php
// Presentation/Views/ViewModificaAccount.php

require_once __DIR__ . '/SmartyConfiguration.php';

class ViewModificaAccount {

    /**
     * Esegue gli assign per la pagina di modifica account e il display del template.
     * $dati è l'array prodotto da CModificaAccount (o controller equivalente) dopo
     * preparaDatiLayout() (va aggiunto nel controller se non già presente, come per ViewProdotto).
     */
    public static function mostraModificaAccount(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        // --- Dati globali di layout (richiedono che il controller chiami preparaDatiLayout) ---
        $smarty->assign('base_url',     $dati['base_url'] ?? '');
        $smarty->assign('current_page', $dati['current_page'] ?? 'modifica-account');
        $smarty->assign('breadcrumbs',  $dati['breadcrumbs'] ?? []);
        $smarty->assign('utente',       $dati['utente'] ?? null);
        $smarty->assign('cart_count',   $dati['cart_count'] ?? 0);

        if (isset($dati['flash_message'])) {
            $smarty->assign('flash_message', $dati['flash_message']);
            $smarty->assign('flash_type', $dati['flash_type']);
        }

        // --- Dati specifici della pagina di modifica account ---
        // NOTA: nel tpl tutti i campi utente (nome, email, eta, avatar, mostra_foto)
        // vengono letti da $utente.* (già assegnato sopra come array associativo).
        // Non ci sono altri assign specifici richiesti da ModificaAccount.tpl:
        // la breadcrumb testuale e i due bottoni Log-out/Elimina account sono
        // hardcoded nel template e non dipendono da variabili aggiuntive.

        $smarty->display('ModificaAccount.tpl');
    }
}