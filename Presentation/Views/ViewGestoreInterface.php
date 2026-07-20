<?php
/**
 * Contratto comune a tutte le View dell'area Gestore che non passano
 * per ViewCatalogo/ViewEventi (dashboard, form di creazione prodotti/eventi).
 */
namespace TableCrown\Presentation\Views;

interface ViewGestoreInterface {

    /**
     * Renderizza la pagina, assegnando i dati a Smarty e mostrando il template.
     */
    public function render(array $dati): void;
}