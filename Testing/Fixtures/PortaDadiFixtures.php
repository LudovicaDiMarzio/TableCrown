<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

use TableCrown\Entity\EPortaDadi;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
use TableCrown\Entity\Enumerativi\Valuta;

class PortaDadiFixture extends AbstractFixture
{
    private const NUM_PORTADADI = 5;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');
        
        // Materiali finti per rendere i nomi più realistici
        $materiali = ["in Legno", "in Velluto", "in Pelle", "in Plastica", "in Resina"];

        echo "Generazione di " . self::NUM_PORTADADI . " porta dadi in corso...\n";

        for ($i = 0; $i < self::NUM_PORTADADI; $i++) {
            
            // Prezzo più basso rispetto ai giochi (es. tra 5 e 25 euro)
            $prezzo = new EPrezzo(
                $faker->randomFloat(2, 5, 25), 
                Valuta::EUR, 
                0
            );

            $materialeCasuale = $faker->randomElement($materiali);

            $portaDadi = new EPortaDadi(
                "Porta Dadi " . $materialeCasuale,                // nomeProdotto
                $faker->paragraph(),                              // descrizione
                DisponibilitaProdotto::Disponibile,               // disponibilita
                $faker->numberBetween(10, 50),                    // quantita in magazzino
                "assets/images/default_portadadi.png",            // img
                $prezzo                                           // prezzo in cascade
            );

            // Segnalibro!
            $this->addReference('portadadi_' . $i, $portaDadi);

            $manager->persist($portaDadi);
        }

        $manager->flush();
        echo "Porta Dadi creati e salvati con successo!\n";
    }
}