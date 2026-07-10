<?php
namespace TableCrown\Entity\Enumerativi;

enum DisponibilitaProdotto: string {
    case Disponibile = "disponibile";
    case NonDisponibile = "non_disponibile";
    case Esaurito = "esaurito";
    case InArrivo = "in_arrivo";
}
