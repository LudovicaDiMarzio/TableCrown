<?php
namespace TableCrown\Entity\Enumerativi;

enum StatoProvvedimento: string {
    case ATTIVO = 'attivo';
    case REVOCATO = 'revocato';
}