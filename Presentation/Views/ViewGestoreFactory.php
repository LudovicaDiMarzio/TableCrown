<?php
/**
 * Costruisce la View concreta corretta in base al nome della vista richiesta.
 */
namespace TableCrown\Presentation\Views;

use InvalidArgumentException;

class ViewGestoreFactory {

    public static function crea(string $vista): ViewGestoreInterface {
        return match ($vista) {
            'gestore_dashboard' => new ViewGestoreDashboard(),

            'gestore_creazione_gioco' => new ViewGestoreCreazioneGioco(),
            'gestore_creazione_bustine' => new ViewGestoreCreazioneBustine(),
            'gestore_creazione_portadadi' => new ViewGestoreCreazionePortaDadi(),
            'gestore_creazione_serata' => new ViewGestoreCreazioneSerata(),
            'gestore_creazione_torneo' => new ViewGestoreCreazioneTorneo(),
            'gestore_creazione_challenge' => new ViewGestoreCreazioneChallenge(),

            default => throw new InvalidArgumentException("Vista gestore non riconosciuta: '$vista'."),
        };
    }
}