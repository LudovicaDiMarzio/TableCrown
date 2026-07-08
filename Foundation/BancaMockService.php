<?php
namespace TableCrown\Foundation;

use Exception;
use InvalidArgumentException;

//questa classe implementa i metodi della interfaccia PaymentInterface utili per il pagamento
class BancaMockService implements PaymentInterface
{
    //serve per generare un token tipo quello che genererebbe stripe
    public function generaToken(string $numeroCarta, string $cvv): array 
    {
        //togliamo tutti gli spazi
        $numeroPulito = preg_replace('/\s+/', '', $numeroCarta);
        $cvvPulito = trim($cvv);

        //controllo che ci siano tra 13 e 19 cifre (come nelle carte reali) e siano solo numeri
        if (strlen($numeroPulito) < 13 || strlen($numeroPulito) > 19 || !is_numeric($numeroPulito)) {
            throw new InvalidArgumentException("Numero di carta non valido. Richiesta rifiutata dalla banca.");
        }

        //controllo che il cvv di 3 cifre e sia numerico
        if (strlen($cvvPulito) < 3 || strlen($cvvPulito) > 4 || !is_numeric($cvvPulito)) {
            throw new InvalidArgumentException("CVV non valido.");
        }

        // Generazione token: "tok_" + 16 caratteri random
        $stringaRandom = bin2hex(random_bytes(8)); //8 byte vengono tradotti in 16 caratteri esadecimali
        $token = 'tok_' . $stringaRandom;

        return [
            'token'              => $token,
            //estraggo le ultime 4 cifre dal numero di carta
            'ultimeQuattroCifre' => substr($numeroPulito, -4)
        ];
    }

    public function effettuaPagamento(string $token, float $importo): bool 
    {
        //controllo che il token esista e che inizi con tok_ (validità del token)
        if (empty($token) || !str_starts_with($token, 'tok_')) {
            throw new Exception("Token di pagamento non valido o assente.");
        }

        //controllo che l'importo sia positivo
        if ($importo <= 0) {
            throw new InvalidArgumentException("L'importo deve essere maggiore di zero.");
        }

        // Simula che la banca dia sempre l'OK al pagamento
        return true; 
    }
}