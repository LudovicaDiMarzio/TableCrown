<?php
namespace TableCrown\Entity\Enumerativi;

enum DisponibilitaProdotto: string {
    case Disponibile = "Disponibile";
    case Esaurito = "Esaurito";
    case InArrivo = "In arrivo";
}
