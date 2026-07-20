<?php
/**
 * Punto d'ingresso statico chiamato da CGestore (stesso ruolo di
 * ViewCatalogo/ViewEventi per le rispettive aree), che poi delega
 * alla View concreta tramite ViewGestoreFactory.
 */
namespace TableCrown\Presentation\Views;

use InvalidArgumentException;

class ViewGestore {

    /**
     * URL: GET /gestore/dashboard (CGestore::mostraDashboardGestore())
     */
    public static function mostraDashboard(array $dati): void {
        $dati['vista'] = $dati['vista'] ?? 'gestore_dashboard';
        ViewGestoreFactory::crea($dati['vista'])->render($dati);
    }

    /**
     * Punto d'ingresso unico per i 6 form di creazione (prodotti ed eventi).
     * TODO T1: CGestore non ha ancora i controller GET che popolano $dati e
     * chiamano questo metodo (mostraFormCreazioneGiocoGestore(), ecc. sono
     * ancora da implementare); i tpl e le View sono però già pronti.
     * $dati['vista'] deve essere una tra: gestore_creazione_gioco,
     * gestore_creazione_bustine, gestore_creazione_portadadi,
     * gestore_creazione_serata, gestore_creazione_torneo, gestore_creazione_challenge.
     */
    public static function mostraFormCreazione(array $dati): void {
        if (!isset($dati['vista'])) {
            throw new InvalidArgumentException("La chiave 'vista' è obbligatoria per mostrare un form di creazione gestore.");
        }
        ViewGestoreFactory::crea($dati['vista'])->render($dati);
    }
}