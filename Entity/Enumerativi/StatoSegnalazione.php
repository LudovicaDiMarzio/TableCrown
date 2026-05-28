<?php
namespace TableCrown\Entity\Enumerativi;
enum StatoSegnalazione: string {
    case IN_ATTESA = 'in attesa';
    case RISOLTA = 'risolta';
}