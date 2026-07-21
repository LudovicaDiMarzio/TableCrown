<?php
namespace TableCrown\Foundation;

/**
 * il control può usare questa interfaccia così finchè il provider sarà PHPMailer andrà bene, se si cambia
 * provider, bisogna cambiare poche righe di codice nel control
*/
interface MailInterface
{
    /**
     * @param string $destinatario indirizzo email del destinatario
     * @param string $oggetto oggetto dell'email
     * @param string $corpo corpo dell'email (può essere HTML)
     * @return bool true se l'invio è andato a buon fine
     */
    public function inviaEmail(string $destinatario, string $oggetto, string $corpo): bool;
}