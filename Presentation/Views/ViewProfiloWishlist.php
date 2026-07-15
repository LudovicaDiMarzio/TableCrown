<?php
// Presentation/Views/ViewProfiloWishlist.php

namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

class ViewProfiloWishlist extends ViewProfiloBase {

    public static function mostraProfiloWishlist(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        self::assegnaGlobali($smarty, $dati, 'profilo-wishlist');

        // --- Dati specifici della pagina wishlist ---
        // 'wishlist' = array di 'prodotti' con la stessa struttura usata
        // in home/catalogo (id, nome, immagine, valutazione_media, prezzo,
        // sconto, prezzo_scontato, percentuale_sconto, disponibilita, isAcquistabile)
        $smarty->assign('wishlist', $dati['wishlist'] ?? []);

        $smarty->display('ProfiloWishlist.tpl');
    }
}