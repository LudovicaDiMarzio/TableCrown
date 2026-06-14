<?php
namespace TableCrown\Entity\Enumerativi;

enum DisponibilitaProdotto: string {
    case Disponibile = "Disponibile";
    case NonDisponibile = "Non disponibile";
    case Esaurito = "Esaurito";
    case InArrivo = "In arrivo";
}
