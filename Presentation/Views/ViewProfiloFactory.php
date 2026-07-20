<?php
// Presentation/Views/ViewProfiloFactory.php

namespace TableCrown\Presentation\Views;

use TableCrown\Presentation\Views\ViewProfiloBase;
use TableCrown\Presentation\Views\ViewProfiloHub;
use TableCrown\Presentation\Views\ViewModificaAccount;
use TableCrown\Presentation\Views\ViewProfiloOrdini;
use TableCrown\Presentation\Views\ViewProfiloRecensioni;
use TableCrown\Presentation\Views\ViewProfiloWishlist;
use TableCrown\Presentation\Views\ViewProfiloEventi;
use TableCrown\Presentation\Views\ViewProfiloIndirizzi;
use TableCrown\Presentation\Views\ViewProfiloPagamenti;
use InvalidArgumentException;

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
            'profilo_pagamenti'  => ViewProfiloPagamenti::mostraProfiloPagamenti($dati),
        };
    }
}