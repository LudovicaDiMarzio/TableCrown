<?php

namespace TableCrown\Presentation\Views;

class ViewProfiloAccount extends ViewProfilo
{
    public function render(array $dati): void
    {
        // Nomi variabili FISSATI come da accordo: dati piatti, NON un array 'utente'.
        $this->smarty->assign('nomeUtente', $dati['nomeUtente']);
        $this->smarty->assign('emailUtente', $dati['emailUtente']);
        $this->smarty->assign('immagineUtente', $dati['immagineUtente'] ?? null);
        $this->smarty->assign('etaUtente', $dati['etaUtente']);

        // Cambio password ed eliminazione account sono gestiti via AJAX
        // (endpoint /account/password e /account/elimina) e non richiedono
        // ulteriori variabili qui.

        $this->smarty->display('ModificaAccount.tpl');
    }
}