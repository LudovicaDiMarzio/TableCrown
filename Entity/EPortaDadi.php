<?php
namespace TableCrown\Entity;

use Doctrine\ORM\Mapping as ORM;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
use DateTime;
use TableCrown\Entity\EPrezzo;

#[ORM\Entity]
#[ORM\Table(name: "porta_dadi")]
class EPortaDadi extends EProdotto {

    public function __construct(string $nomeProdotto, ?string $imgProdotto = null, string $descrizioneProdotto, DisponibilitaProdotto $disponibilitaProdotto, int $quantita, DateTime $dataPubblicazione, ?EPrezzo $prezzo = null)
    {
        parent::__construct($nomeProdotto, $imgProdotto, $descrizioneProdotto, $disponibilitaProdotto, $quantita, $dataPubblicazione, $prezzo);
    }


}