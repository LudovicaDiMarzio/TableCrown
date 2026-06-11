<?php
namespace TableCrown\Entity;

use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
use DateTime;
use TableCrown\Entity\EPrezzo;

class EBustine extends EProdotto{
    
	public function __construct(?int $idProdotto, string $nomeProdotto, ?string $imgProdotto, string $descrizioneProdotto, DisponibilitaProdotto $disponibilitaProdotto, int $quantita, DateTime $dataPubblicazione, ?EPrezzo $prezzo = null, array $recensioni = [])
    {
        parent::__construct($idProdotto, $nomeProdotto, $imgProdotto, $descrizioneProdotto, $disponibilitaProdotto, $quantita, $dataPubblicazione, $prezzo, $recensioni);
    }
}