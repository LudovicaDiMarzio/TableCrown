<?php
namespace TableCrown\Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface; 
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

use TableCrown\Entity\ESegnalazione;
use TableCrown\Entity\ERecensione;       
use TableCrown\Entity\EMotivazione;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\Enumerativi\StatoSegnalazione;

// Aggiungiamo 'implements DependentFixtureInterface' per gestire l'ordine di esecuzione
class SegnalazioneFixture extends AbstractFixture implements DependentFixtureInterface
{
        // metodo obbligatorio che dice quali fixture devono essere caricate prima di eseguire questa fixture
    public function getDependencies(): array
    {
        return [
            RecensioneFixture::class,
            MotivazioneFixture::class,
        ];
    }
    private const NUM_SEGNALAZIONI = 30;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        for ($i = 0; $i < self::NUM_SEGNALAZIONI; $i++) {
            
            // Sappiamo che abbiamo creato 50 segnalazioni (da 0 a 49) nella fixture di Recensioni            
            $recensione = $this->getReference(
                'recensione_' . $faker->numberBetween(0, 49), 
                ERecensione::class
            );
            
            //abbiamo creato 4 tipologie di motivazioni nella fixture di Motivazione
            $motivazioneCasuale = $this->getReference(
                'motivazione_' . $faker->numberBetween(0, 3), 
                EMotivazione::class
            );

             $utenteSegnalante = $this->getReference(
                'utente_' . $faker->numberBetween(0, 19), 
                EUtente::class
            );

            //  Creiamo la segnalazione passandogli gli oggetti appena recuperati motivazione e recensione
            $segnalazione = new ESegnalazione(
                $motivazioneCasuale, 
                $recensione,
                $utenteSegnalante
            );

            // il costruttore imposta le segnalazioni "IN_ATTESA", 
            // mettiamo che il 40% delle segnalazioni siano già state "risolte" dall'admin
            //La funzione $faker->boolean(40) serve a generare un valore booleano casuale (true o false) con una probabilità personalizzata.
            //con il 40% di probabilità restituisce true, con il restante 60% false
            if ($faker->boolean(40)) {//
                $segnalazione->risolvi();
            }

            // salvo il riferimento per usarlo in altre fixture
            $this->addReference('segnalazione_' . $i, $segnalazione);
            //creo l'entità nell'IdentityMap e nella UnitOfWork
            $manager->persist($segnalazione);
        }

        // eseguo le query nella UnitOfWork
        $manager->flush();
    }

   
}