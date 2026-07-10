<?php
namespace TableCrown\Testing\Fixtures;
 
//estendo la classe abstract fixture per poter usare i metodi di doctrine addReference e getReference per gestire i riferimenti tra classi
use Doctrine\Common\DataFixtures\AbstractFixture;

//estendo la classe object manager per poter usare i metodi di doctrine persist, flush ecc ecc (permette di gestire il ciclo di vita delle entità)
use Doctrine\Persistence\ObjectManager;

//libreria esterna per generare i dati random
use Faker\Factory;

//importo le classi Entity e gli enum necessari
use TableCrown\Entity\EBustine;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\Enumerativi\Valuta;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
use DateTime;



class BustineFixture extends AbstractFixture
{
    private const NUM_BUSTINE = 10;

    //metodo doctrine che viene eseguito da FixtureLoad.php per creare le entità e salvarle nel database
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT'); //creazione istanza di faker per la lingua italiana

        for ($i = 0; $i < self::NUM_BUSTINE; $i++) { //self::NUM_BUSTINE serve per leggere la costante
            
            // Creiamo un prezzo casuale (sfruttando il Cascade Persist di cui parlavamo!)
            $prezzo = new EPrezzo($faker->randomFloat(2, 2, 15), Valuta::EUR);

            // 2. Peschiamo un valore a caso dall'Enum della disponibilità
            $disponibilita = $faker->randomElement(DisponibilitaProdotto::cases());

            //chiamo il costruttore di EBustine con i dati random
            $bustina = new EBustine(
                $faker->words(3, true),           // nomeProdotto
                $faker->paragraph(),              // descrizioneProdotto
                $disponibilita,                   // disponibilitaProdotto
                $faker->numberBetween(10, 100),   // quantita
                prezzo: $prezzo,                     // prezzo
                );

                //per le ultime 2 bustine aggiungiamo uno sconto
                if($i===8){
                    $prezzo->aggiornaSconto(20, new DateTime('2026-08-01')); //sconto del 20%
                }
                elseif($i===9){
                    $prezzo->aggiornaSconto(30, new DateTime('2026-07-25')); //sconto del 30%
                }

                // salva riferimento per usarlo in altre fixture
                $this->addReference('bustine_' . $i, $bustina);
                //salva la traccia dell'entità nel IdentityMap e nella UnitOfWork
                $manager->persist($bustina);
        }


        //esegue le query appese nella UnitOfWork
        $manager->flush();
    }
}
