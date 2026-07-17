<?php
namespace TableCrown\Presentation\Views;

/**
 * Contratto comune per tutte le View dell'area amministratore.
 */
interface ViewAdminInterface {

    /**
     * Effettua l'assign dei dati e il display del template Smarty
     * corrispondente a questa specifica interfaccia admin.
     */
    public function mostra(array $data): void;
}