<?php
namespace TableCrown\Foundation;

/*questa interfaccia permette di definire un contratto per i servizi di pagmento, il control si affida a ad essa
i metodi veri e propri saranno implementati nella mock, in questo caso, ma se in futuro si decide di usare un servizio di pagamento reale,
sarà possibile implementare il contratto in modo più semplice semplicemente modificando la chiamata al servizio di pagamento nel control, senza dover riscrivere tutto il codice del control stesso.
*/
interface PaymentInterface 
{
    public function generaToken(string $numeroCarta, string $cvv): array;
    public function effettuaPagamento(string $token, float $importo): bool;
}