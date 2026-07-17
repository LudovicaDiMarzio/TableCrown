<?php
namespace TableCrown\Presentation\Views;

/**
 * Dispatcher statico per l'area amministratore.
 * Ogni metodo corrisponde 1:1 a una chiamata già presente in CAmministratore
 * e indirizza alla classe View concreta corretta.
 */
class ViewAdminFactory {

    /**
     * Mostra la dashboard admin.
     * Chiamata da: CAmministratore::mostraDashboardAdmin()
     */
    public static function mostraDashboard(array $data): void {
        (new ViewDashboardAdmin())->mostra($data);
    }

    /**
     * Mostra la lista utenti con recensioni segnalate.
     * Chiamata da: CAmministratore::mostraListaUtentiAdmin()
     */
    public static function mostraListaUtenti(array $data): void {
        (new ViewListaUtentiAdmin())->mostra($data);
    }

    /**
     * Mostra il profilo di un singolo utente lato admin.
     * Chiamata da: CAmministratore::mostraProfiloUtenteAdmin()
     */
    public static function mostraProfiloUtente(array $data): void {
        (new ViewProfiloUtenteAdmin())->mostra($data);
    }

    /**
     * Mostra la lista delle recensioni segnalate.
     * Chiamata da: CAmministratore::mostraListaRecensioniAdmin()
     */
    public static function mostraListaRecensioni(array $data): void {
        (new ViewListaRecensioniAdmin())->mostra($data);
    }
}