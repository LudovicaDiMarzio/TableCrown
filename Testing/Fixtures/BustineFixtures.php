<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

use TableCrown\Entity\EBustine;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
use TableCrown\Entity\Enumerativi\Valuta;

class BustineFixture extends AbstractFixture
{
    private const NUM_BUSTINE = 5;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');
        
        // Formati standard per le bustine dei giochi da tavolo
        $formati = ["Standard 63x88mm", "Mini Euro 45x68mm", "Tarot 70x120mm", "Square 70x70mm"];

        echo "Generazione di " . self::NUM_BUSTINE . " pacchi di bustine in corso...\n";

        for ($i = 0; $i < self::NUM_BUSTINE; $i++) {
            
            // Le bustine costano poco (es. tra 2 e 6 euro)
            $prezzo = new EPrezzo(
                $faker->randomFloat(2, 2, 6), 
                Valuta::EUR, 
                0
            );

            $formatoCasuale = $faker->randomElement($formati);

            $bustine = new EBustine(
                "Bustine Protettive " . $formatoCasuale,          // nomeProdotto
                $faker->paragraph(),                              // descrizione
                DisponibilitaProdotto::Disponibile,               // disponibilita
                $faker->numberBetween(50, 200),                   // quantita (ne servono tante!)
                "assets/images/default_bustine.png",              // img
                $prezzo                                           // prezzo in cascade
            );

            // Segnalibro!
            $this->addReference('bustine_' . $i, $bustine);

            $manager->persist($bustine);
        }

        $manager->flush();
        echo "Bustine protettive create e salvate con successo!\n";
    }
}