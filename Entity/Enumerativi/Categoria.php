<?php
namespace TableCrown\Entity\Enumerativi;

enum Categoria: string {
    case Strategia = "strategia";
    case Famiglia = "famiglia";
    case PartyGame = "party game";
    case Cooperativo = "cooperativo";
    case Avventura = "avventura";
    case Carte = "carte";
    case Educativo = "educativo";
    case GDR = "gdr";
    case Puzzle = "puzzle";
    case Bambini = "bambini";
}