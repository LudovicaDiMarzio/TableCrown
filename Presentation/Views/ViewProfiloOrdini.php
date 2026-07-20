<?php
// Presentation/Views/ViewProfiloOrdini.php

namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

class ViewProfiloOrdini extends ViewProfiloBase {

    public static function mostraProfiloOrdini(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        self::assegnaGlobali($smarty, $dati, 'profilo-ordini');

        // --- Dati specifici della pagina ordini ---
        // 'ordini' deve arrivare già con: id, data, stato, totale (string 2 decimali),
        // indirizzoSpedizione, ultimeQuattroCifreCarta, nomeTitolareCarta,
        // isAnnullabile, items[] (prodotto + quantita + prezzoUnitario (string 2 decimali)
        // + scontoApplicato + totaleItem (string 2 decimali))
        $smarty->assign('ordini', $dati['ordini'] ?? []);

        $smarty->display('MioOrdine.tpl');
    }
}