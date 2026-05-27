<?php
namespace TableCrown\Entity\Enumerativi;

enum StatoEvento: string {
    case Programmato = "Programmato";
    case InCorso = "In corso";
    case Terminato = "Terminato";
    case Annullato = "Annullato";
}
