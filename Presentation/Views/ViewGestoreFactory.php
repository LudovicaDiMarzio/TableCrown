<?php

namespace TableCrown\Presentation\Views;

class ViewGestoreFactory {

    public static function mostraDashboard(array $dati): void {
        (new ViewGestoreDashboard())->render($dati);
    }

    public static function mostraCatalogoGiochi(array $dati): void {
        (new ViewGestoreCatalogoGiochi())->render($dati);
    }

    public static function mostraCatalogoBustine(array $dati): void {
        (new ViewGestoreCatalogoBustine())->render($dati);
    }

    public static function mostraCatalogoPortaDadi(array $dati): void {
        (new ViewGestoreCatalogoPortaDadi())->render($dati);
    }

    public static function mostraFormCreazione(array $dati): void {
        $view = match ($dati['vista']) {
            'gestore_creazione_gioco'     => new ViewGestoreCreazioneGioco(),
            'gestore_creazione_bustine'   => new ViewGestoreCreazioneBustine(),
            'gestore_creazione_portadadi' => new ViewGestoreCreazionePortaDadi(),
            'gestore_creazione_serata'    => new ViewGestoreCreazioneSerata(),
            'gestore_creazione_torneo'    => new ViewGestoreCreazioneTorneo(),
            'gestore_creazione_challenge' => new ViewGestoreCreazioneChallenge(),
            default => throw new \InvalidArgumentException("Vista di creazione non riconosciuta: '{$dati['vista']}'."),
        };

        $view->render($dati);
    }
    public static function mostraModificaProdotto(array $dati): void {
    $view = match ($dati['vista']) {
        'gestore_modifica_gioco'     => new ViewGestoreModificaGioco(),
        'gestore_modifica_bustine'   => new ViewGestoreModificaBustine(),
        'gestore_modifica_portadadi' => new ViewGestoreModificaPortaDadi(),
        default => throw new \InvalidArgumentException("Vista di modifica non riconosciuta: '{$dati['vista']}'."),
    };

    $view->render($dati);
}

public static function mostraDettaglioSerata(array $dati): void {
    (new ViewGestoreDettaglioSerata())->render($dati);
}

public static function mostraDettaglioTorneo(array $dati): void {
    (new ViewGestoreDettaglioTorneo())->render($dati);
}

public static function mostraDettaglioChallenge(array $dati): void {
    (new ViewGestoreDettaglioChallenge())->render($dati);
}

public static function mostraEventiSerate(array $dati): void {
    (new ViewGestoreEventiSerate())->render($dati);
}

public static function mostraEventiTornei(array $dati): void {
    (new ViewGestoreEventiTornei())->render($dati);
}

public static function mostraEventiChallenge(array $dati): void {
    (new ViewGestoreEventiChallenge())->render($dati);
}
}
