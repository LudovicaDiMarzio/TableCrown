<?php
namespace TableCrown\Utility;

class UFlashMessage {

    /**
     * Aggiunge un messaggio flash alla sessione.
     * $type è il tipo visivo: 'success', 'warning', 'danger', 'info'
     * $message è il testo del messaggio
     * I messaggi sono organizzati per tipo in un array associativo.
     * $_SESSION['flash'] = ['success' => ['Prodotto aggiunto al carrello.'], 'danger' => ['Errore']]
     */
    public static function addMessage(string $type, string $message): void {
        //Se esistono già messaggi flash li recupera, altrimenti parte da un array vuoto
        $messages = USession::isSetSessionElement('flash')
            ? USession::getSessionElement('flash')
            : [];
        //Aggiunge il nuovo messaggio all'array del tipo corrispondente
        //[] dopo $type significa "aggiungi in fondo all'array di quel tipo"
        $messages[$type][] = $message;
        //Salva l'array aggiornato nella sessione
        USession::setSessionElement('flash', $messages);
    }

    //Recupera tutti i messaggi flash e li elimina dalla sessione
    //va chiamato nella View dopo aver mostrato i messaggi
    public static function getMessage(): array {
        if (!USession::isSetSessionElement('flash')) {
            return [];
        }

        $messages = USession::getSessionElement('flash');
        //Elimina i messaggi dalla sessione - così compaiono una sola volta
        USession::unsetSessionElement('flash');

        return $messages;
    }

    //Verifica se ci sono messaggi flash da mostrare
    //utile nella View per decidere se mostrare la sezione dei messaggi
    public static function hasMessage(): bool {
        return USession::isSetSessionElement('flash');
    }
}