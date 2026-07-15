<?php
// Presentation/Views/ViewProfiloWishlist.php

namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

class ViewProfiloWishlist {

    public static function mostraProfiloWishlist(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        // --- Dati globali di layout ---
        $smarty->assign('base_url',     $dati['base_url'] ?? '');
        $smarty->assign('current_page', $dati['current_page'] ?? 'profilo-wishlist');
        $smarty->assign('breadcrumbs',  $dati['breadcrumbs'] ?? []);
        $smarty->assign('utente',       $dati['utente'] ?? null);
        $smarty->assign('cart_count',   $dati['cart_count'] ?? 0);

        if (isset($dati['flash_message'])) {
            $smarty->assign('flash_message', $dati['flash_message']);
            $smarty->assign('flash_type', $dati['flash_type']);
        }

        // --- Dati specifici della pagina wishlist ---
        // 'wishlist' = array di 'prodotti' con la stessa struttura usata
        // in home/catalogo (id, nome, immagine, valutazione_media, prezzo,
        // sconto, prezzo_scontato, percentuale_sconto, disponibilita, isAcquistabile)
        $smarty->assign('wishlist', $dati['wishlist'] ?? []);

        $smarty->display('ProfiloWishlist.tpl');
    }
}