<?php
namespace TableCrown\Presentation\Views;

use TableCrown\Foundation\SmartyConfiguration;

/**
 * Classe deputata alla presentazione delle interfacce di autenticazione (login e registrazione).
 * Riceve i dati già preparati dal controller (CAutenticazione) e si occupa esclusivamente
 * del rendering Smarty, seguendo il pattern di ViewCarrello.php.
 */
class ViewAutenticazione {

    private const TPL_LOGIN = 'accedi.tpl';
    private const TPL_REGISTRAZIONE = 'registrati.tpl';

    /**
     * Assegna al motore Smarty le variabili comuni a entrambe le pagine di autenticazione
     * (layout, breadcrumb, ecc.). Metodo privato condiviso, pronto anche per eventuali
     * variabili extra comuni future.
     */
    private static function assignComuni($smarty, array $datiLayout): void {
        foreach ($datiLayout as $chiave => $valore) {
            $smarty->assign($chiave, $valore);
        }
    }

    /**
     * Mostra il form di login.
     * $datiLayout può contenere, oltre ai dati di layout standard:
     * - errore (?string)
     * - messaggio (?string)
     * - redirect_to (?string)
     * - email_value (?string)
     * - ricordami (?bool)
     */
    public static function mostraFormLogin(array $datiLayout): void {
        $smarty = SmartyConfiguration::getSmarty();
        self::assignComuni($smarty, $datiLayout);
        $smarty->display(self::TPL_LOGIN);
    }

    /**
     * Mostra il form di registrazione.
     * $datiLayout può contenere, oltre ai dati di layout standard:
     * - errore (?string)
     * - nickname_value (?string)
     * - email_value (?string)
     * - eta_value (?int)
     */
    public static function mostraFormRegistrazione(array $datiLayout): void {
        $smarty = SmartyConfiguration::getSmarty();
        self::assignComuni($smarty, $datiLayout);
        $smarty->display(self::TPL_REGISTRAZIONE);
    }
}
