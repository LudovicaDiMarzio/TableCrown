<?php
namespace TableCrown\Entity\Enumerativi;
enum StatoUtente: string {
    case ATTIVO = 'attivo';
    case SOSPESO = 'sospeso';
    case BANNATO = 'bannato';
}