<?php
// Presentation/Views/ViewProfiloOrdini.php

namespace TableCrown\Presentation\Views;

use SmartyConfiguration;;

class ViewProfiloOrdini {

    public static function mostraProfiloOrdini(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        // --- Dati globali di layout ---
        $smarty->assign('base_url',     $dati['base_url'] ?? '');
        $smarty->assign('current_page', $dati['current_page'] ?? 'profilo-ordini');
        $smarty->assign('breadcrumbs',  $dati['breadcrumbs'] ?? []);
        $smarty->assign('utente',       $dati['utente'] ?? null);
        $smarty->assign('cart_count',   $dati['cart_count'] ?? 0);

        if (isset($dati['flash_message'])) {
            $smarty->assign('flash_message', $dati['flash_message']);
            $smarty->assign('flash_type', $dati['flash_type']);
        }

        // --- Dati specifici della pagina ordini ---
        // 'ordini' deve arrivare già con: id, data, stato, totale (string 2 decimali),
        // indirizzoSpedizione, ultimeQuattroCifreCarta, nomeTitolareCarta,
        // isAnnullabile, items[] (prodotto + quantita + prezzoUnitario (string 2 decimali)
        // + scontoApplicato + totaleItem (string 2 decimali))
        $smarty->assign('ordini', $dati['ordini'] ?? []);

        $smarty->display('ProfiloOrdini.tpl');
    }
}