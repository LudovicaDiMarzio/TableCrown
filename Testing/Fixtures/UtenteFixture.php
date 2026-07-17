<?php
namespace TableCrown\Testing\Fixtures;

use DateTime;  
//estendo la classe abstract fixture per poter usare i metodi di doctrine addReference e getReference per gestire i riferimenti tra classi
use Doctrine\Common\DataFixtures\AbstractFixture;

//estendo la classe object manager per poter usare i metodi di doctrine persist, flush ecc ecc (permette di gestire il ciclo di vita delle entità)
use Doctrine\Persistence\ObjectManager;

//libreria esterna per generare i dati random
use Faker\Factory;

//importo le classi Entity e gli enum necessari
use TableCrown\Entity\EUtente;
use TableCrown\Entity\Enumerativi\PlayerLevel;


class UtenteFixture extends AbstractFixture
{
    private const NUM_UTENTI = 20;

    //metodo doctrine che viene eseguito da FixtureLoad.php per creare le entità e salvarle nel database
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT'); //creazione istanza di faker per la lingua italiana

        for ($i = 0; $i < self::NUM_UTENTI; $i++) { //self::NUM_UTENTI serve per leggere la costante
            //chiamo il costruttore di EUtente con i dati random
            $utente = new EUtente(
                $faker->firstName() . ' ' . $faker->lastName(),
                $faker->unique()->safeEmail(),
                'Password123!',
                //faker per immagine profilo
                $faker->dateTimeBetween('-90 years','-18 years'),
                $faker->randomElement(PlayerLevel::cases()) //PlayerLevel::cases() recupera un array contenente tutti i valori possibili definiti nell'enumerativo PlayerLevel
                
            );
            if ($i === 18) 
                {
                    $utente->sospendi(new DateTime('+7 days'));
                } 
            elseif ($i === 19) 
                {
                    $utente->banna();
                }


            // salva riferimento per usarlo in altre fixture
            $this->addReference('utente_' . $i, $utente);

            //salva la traccia dell'entità nel IdentityMap e nella UnitOfWork
            $manager->persist($utente);
        }


        //esegue le query appese nella UnitOfWork
        $manager->flush();
    }
}
