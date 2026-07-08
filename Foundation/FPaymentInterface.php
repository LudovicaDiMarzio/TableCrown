<?php
namespace TableCrown\Foundation;

interface PaymentInterface 
{
    public function generaToken(string $numeroCarta, string $cvv): array;
    public function effettuaPagamento(string $token, float $importo): bool;
}