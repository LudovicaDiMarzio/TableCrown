<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

// Importiamo le Entity e l'Enum
use TableCrown\Entity\EDanno;
use TableCrown\Entity\Enumerativi\LivelloDannoGiochi;

class DannoFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        echo "Generazione delle regole di sconto per i danni in corso...\n";

        // Estraiamo in automatico tutti i casi del tuo Enum (es. L1, L2, L3)
        $livelliDisponibili = LivelloDannoGiochi::cases();

        // Prepariamo degli sconti realistici in ordine crescente
        $scontiProgressione = [10.0, 25.0, 45.0];

        foreach ($livelliDisponibili as $indice => $livello) {
            
            // Se hai più di 3 livelli nell'Enum, calcola uno sconto di default
            $sconto = isset($scontiProgressione[$indice]) ? $scontiProgressione[$indice] : 15.0 * ($indice + 1);

            // Creiamo il record Danno
            $danno = new EDanno($livello, $sconto);

            // Salviamo il segnalibro usando direttamente il nome dell'Enum! (es. "danno_L1")
            // Ti sarà utilissimo se in futuro vorrai associare un Danno a un EProdotto usato
            $this->addReference('danno_' . $livello->name, $danno);

            $manager->persist($danno);
        }

        $manager->flush();
        echo "Livelli di danno e relativi sconti creati e salvati con successo!\n";
    }
}