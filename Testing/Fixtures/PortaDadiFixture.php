<?php
namespace TableCrown\Testing\Fixtures;
 
//estendo la classe abstract fixture per poter usare i metodi di doctrine addReference e getReference per gestire i riferimenti tra classi
use Doctrine\Common\DataFixtures\AbstractFixture;

//estendo la classe object manager per poter usare i metodi di doctrine persist, flush ecc ecc (permette di gestire il ciclo di vita delle entità)
use Doctrine\Persistence\ObjectManager;

//libreria esterna per generare i dati random
use Faker\Factory;

//importo le classi Entity e gli enum necessari
use TableCrown\Entity\EPortaDadi;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\Enumerativi\Valuta;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;



class PortaDadiFixture extends AbstractFixture
{
    private const NUM_PORTADADI = 10;

    //metodo doctrine che viene eseguito da FixtureLoad.php per creare le entità e salvarle nel database
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT'); //creazione istanza di faker per la lingua italiana
        $percorsoImg = __DIR__ . '/../../public/img/default_game.jpg'; 
        if (!file_exists($percorsoImg)) {
            throw new \Exception("\n\nERRORE GRAVE: Non riesco a trovare l'immagine per i PortaDadi!\nPercorso calcolato: " . $percorsoImg . "\n\n");
        }
        $immaginePredefinita = file_get_contents($percorsoImg);

        for ($i = 0; $i < self::NUM_PORTADADI; $i++) { //self::NUM_BUSTINE serve per leggere la costante
            
            // Creiamo un prezzo casuale (sfruttando il Cascade Persist di cui parlavamo!)
            $prezzo = new EPrezzo($faker->randomFloat(2, 2, 15), Valuta::EUR);

            // 2. Peschiamo un valore a caso dall'Enum della disponibilità
            $disponibilita = $faker->randomElement(DisponibilitaProdotto::cases());

            //chiamo il costruttore di EBustine con i dati random
            $porta_dadi= new EPortaDadi(
                $faker->words(3, true),           // nomeProdotto
                $faker->paragraph(),              // descrizioneProdotto
                $disponibilita,                   // disponibilitaProdotto
                $faker->numberBetween(10, 100),
                imgProdotto: $immaginePredefinita,   // quantita
                prezzo: $prezzo,                     // prezzo
                );

                // salva riferimento per usarlo in altre fixture
                $this->addReference('porta_dadi_' . $i, $porta_dadi);
                //salva la traccia dell'entità nel IdentityMap e nella UnitOfWork
                $manager->persist($porta_dadi);
        }


        //esegue le query appese nella UnitOfWork
        $manager->flush();
    }
}
