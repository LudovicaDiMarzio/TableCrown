<?php
// Presentation/Views/ViewProfiloHub.php

require_once __DIR__ . '/SmartyConfiguration.php';

class ViewProfiloHub {

    public static function mostraProfiloHub(array $dati): void {
        $smarty = SmartyConfiguration::getSmarty();

        // --- Dati globali di layout ---
        $smarty->assign('base_url',     $dati['base_url'] ?? '');
        $smarty->assign('current_page', $dati['current_page'] ?? 'profilo-hub');
        $smarty->assign('breadcrumbs',  $dati['breadcrumbs'] ?? []);
        $smarty->assign('utente',       $dati['utente'] ?? null);
        $smarty->assign('cart_count',   $dati['cart_count'] ?? 0);

        if (isset($dati['flash_message'])) {
            $smarty->assign('flash_message', $dati['flash_message']);
            $smarty->assign('flash_type', $dati['flash_type']);
        }

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
        $smarty->assign('menuVoci', [
            ['label' => 'Modifica Account', 'url' => '/account/modifica'],
            ['label' => 'I Miei Ordini',     'url' => '/account/ordini'],
            ['label' => 'Le Mie Recensioni', 'url' => '/account/recensioni'],
            ['label' => 'Wishlist',          'url' => '/account/wishlist'],
            ['label' => 'Eventi',            'url' => '/account/eventi'],
            ['label' => 'I Miei Indirizzi',  'url' => '/account/indirizzi'],
        ]);

        $smarty->display('ProfiloHub.tpl');
    }
}