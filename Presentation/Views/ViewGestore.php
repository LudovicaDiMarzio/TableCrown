<?php
namespace TableCrown\Presentation\Views;

use InvalidArgumentException;

class ViewGestore {

    public static function mostraDashboard(array $dati): void {
        ViewGestoreFactory::mostraDashboard($dati);
    }

    public static function mostraCatalogoGiochi(array $dati): void {
        ViewGestoreFactory::mostraCatalogoGiochi($dati);
    }

    public static function mostraCatalogoBustine(array $dati): void {
        ViewGestoreFactory::mostraCatalogoBustine($dati);
    }

    public static function mostraCatalogoPortaDadi(array $dati): void {
        ViewGestoreFactory::mostraCatalogoPortaDadi($dati);
    }

    public static function mostraFormCreazione(array $dati): void {
        if (!isset($dati['vista'])) {
            throw new InvalidArgumentException("La chiave 'vista' è obbligatoria per mostrare un form di creazione gestore.");
        }
        ViewGestoreFactory::mostraFormCreazione($dati);
    }

    public static function mostraModificaProdotto(array $dati): void {
    if (!isset($dati['vista'])) {
        throw new InvalidArgumentException("La chiave 'vista' è obbligatoria per mostrare la modifica di un prodotto gestore.");
    }
    ViewGestoreFactory::mostraModificaProdotto($dati);
}


}