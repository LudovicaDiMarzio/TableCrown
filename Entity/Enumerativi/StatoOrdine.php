<?php
namespace TableCrown\Entity\Enumerativi;
enum StatoOrdine: string {
    case IN_LAVORAZIONE = "in attesa";
    case SPEDITO = "spedito";
    case CONSEGNATO = "consegnato";
    case ANNULLATO = "annullato";
}