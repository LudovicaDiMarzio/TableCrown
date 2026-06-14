<?php
namespace TableCrown\Entity;

use Doctrine\ORM\Mapping as ORM;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
use DateTime;
use TableCrown\Entity\EPrezzo;

#[ORM\Entity]
#[ORM\Table(name: "bustine")]
class EBustine extends EProdotto{
    
	public function __construct(string $nomeProdotto, string $descrizioneProdotto, DisponibilitaProdotto $disponibilitaProdotto, int $quantita, ?string $imgProdotto = null, ?EPrezzo $prezzo = null)
    {
        parent::__construct($nomeProdotto, $descrizioneProdotto, $disponibilitaProdotto, $quantita, $imgProdotto, $prezzo);
    }
}