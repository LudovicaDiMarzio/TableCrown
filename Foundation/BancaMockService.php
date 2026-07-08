<?php
namespace TableCrown\Foundation;

use Exception;
use InvalidArgumentException;

class BancaMockService implements PaymentInterface
{
    public function generaToken(string $numeroCarta, string $cvv): array 
    {
        $numeroPulito = preg_replace('/\s+/', '', $numeroCarta);
        $cvvPulito = trim($cvv);

        if (strlen($numeroPulito) < 13 || strlen($numeroPulito) > 19 || !is_numeric($numeroPulito)) {
            throw new InvalidArgumentException("Numero di carta non valido. Richiesta rifiutata dalla banca.");
        }

        if (strlen($cvvPulito) < 3 || strlen($cvvPulito) > 4 || !is_numeric($cvvPulito)) {
            throw new InvalidArgumentException("CVV non valido.");
        }

        // Generazione token: "tok_" + 16 caratteri random
        $caratteri = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $stringaRandom = substr(str_shuffle(str_repeat($caratteri, 5)), 0, 16);
        $token = 'tok_' . $stringaRandom;

        return [
            'token'              => $token,
            'ultimeQuattroCifre' => substr($numeroPulito, -4)
        ];
    }

    public function effettuaPagamento(string $token, float $importo): bool 
    {
        if (empty($token) || strpos($token, 'tok_') !== 0) {
            throw new Exception("Token di pagamento non valido o assente.");
        }

        if ($importo <= 0) {
            throw new InvalidArgumentException("L'importo deve essere maggiore di zero.");
        }

        // Simula che la banca dia sempre l'OK
        return true; 
    }
}