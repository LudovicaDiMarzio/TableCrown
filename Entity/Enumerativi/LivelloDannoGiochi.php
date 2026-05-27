<?php
namespace TableCrown\Entity\Enumerativi;

enum LivelloDannoGiochi: string {
    case L1 = "danno leggero";
    case L2 = "danno moderato";
    case L3 = "danno grave";
}