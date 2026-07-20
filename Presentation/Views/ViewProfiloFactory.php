<?php
// Presentation/Views/ViewProfiloFactory.php

use Presentation\Views\ViewProfiloBase;
use Presentation\Views\ViewProfiloHub;
use Presentation\Views\ViewModificaAccount;
use Presentation\Views\ViewProfiloOrdini;
use Presentation\Views\ViewProfiloRecensioni;
use Presentation\Views\ViewProfiloWishlist;
use Presentation\Views\ViewProfiloEventi;
use Presentation\Views\ViewProfiloIndirizzi;
use Presentation\Views\ViewProfiloPagamenti;

class ViewProfiloFactory {

    private const VISTE_VALIDE = [
        'profilo_hub',
        'profilo_account',
        'profilo_ordini',
        'profilo_recensioni',
        'profilo_wishlist',
        'profilo_eventi',
        'profilo_indirizzi',
        'profilo_pagamenti',
    ];

    /**
     * Legge 'vista' da $dati e invoca il metodo statico corretto.
     * Control chiama solo: ViewProfiloFactory::render($dati);
     */
    public static function render(array $dati): void {
        $vista = $dati['vista'] ?? null;

        if ($vista === null || !in_array($vista, self::VISTE_VALIDE, true)) {
            throw new InvalidArgumentException("Vista profilo non valida: " . ($vista ?? 'non specificata'));
        }

        match ($vista) {
            'profilo_hub'        => ViewProfiloHub::mostraProfiloHub($dati),
            'profilo_account'    => ViewModificaAccount::mostraModificaAccount($dati),
            'profilo_ordini'     => ViewProfiloOrdini::mostraProfiloOrdini($dati),
            'profilo_recensioni' => ViewProfiloRecensioni::mostraProfiloRecensioni($dati),
            'profilo_wishlist'   => ViewProfiloWishlist::mostraProfiloWishlist($dati),
            'profilo_eventi'     => ViewProfiloEventi::mostraProfiloEventi($dati),
            'profilo_indirizzi'  => ViewProfiloIndirizzi::mostraProfiloIndirizzi($dati),
            'profilo_pagamenti' => ViewProfiloPagamenti::mostraProfiloPagamenti($dati),
        };
    }
}