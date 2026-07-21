<?php
/**
 * Punto d'ingresso statico chiamato da CGestore (stesso ruolo di
 * ViewCatalogo/ViewEventi per le rispettive aree), che poi delega
 * alla View concreta tramite ViewGestoreFactory.
 */
namespace TableCrown\Presentation\Views;

use SmartyConfiguration;

use InvalidArgumentException;

class ViewGestore {

    /**
     * URL: GET /gestore/dashboard (CGestore::mostraDashboardGestore())
     */
    public static function mostraDashboard(array $dati): void {
        $dati['vista'] = $dati['vista'] ?? 'gestore_dashboard';
        ViewGestoreFactory::crea($dati['vista'])->render($dati);
    }

    public static function mostraFormCreazione(array $dati): void {
        if (!isset($dati['vista'])) {
            throw new InvalidArgumentException("La chiave 'vista' è obbligatoria per mostrare un form di creazione gestore.");
        }
        ViewGestoreFactory::crea($dati['vista'])->render($dati);
    }
}