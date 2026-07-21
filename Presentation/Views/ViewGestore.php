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

public static function mostraDettaglioSerata(array $dati): void {
    ViewGestoreFactory::mostraDettaglioSerata($dati);
}

public static function mostraDettaglioTorneo(array $dati): void {
    ViewGestoreFactory::mostraDettaglioTorneo($dati);
}

public static function mostraDettaglioChallenge(array $dati): void {
    ViewGestoreFactory::mostraDettaglioChallenge($dati);
}

public static function mostraEventiSerate(array $dati): void {
    ViewGestoreFactory::mostraEventiSerate($dati);
}

public static function mostraEventiTornei(array $dati): void {
    ViewGestoreFactory::mostraEventiTornei($dati);
}

public static function mostraEventiChallenge(array $dati): void {
    ViewGestoreFactory::mostraEventiChallenge($dati);
}


}