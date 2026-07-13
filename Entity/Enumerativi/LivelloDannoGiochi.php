<?php
namespace TableCrown\Entity\Enumerativi;

enum LivelloDannoGiochi: string {
    case L1 = "danno_leggero";
    case L2 = "danno_moderato";
    case L3 = "danno_grave";
}