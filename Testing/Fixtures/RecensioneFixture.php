<?php
namespace TableCrown\Testing\Fixtures;
 
//estendo la classe abstract fixture per poter usare i metodi di doctrine addReference e getReference per gestire i riferimenti tra classi
use Doctrine\Common\DataFixtures\AbstractFixture;

//estendo la classe object manager per poter usare i metodi di doctrine persist, flush ecc ecc (permette di gestire il ciclo di vita delle entità)
use Doctrine\Persistence\ObjectManager;

//libreria esterna per generare i dati random
use Faker\Factory;

//per creare relazioni tra entità è necessario implementare l'interfaccia dependent fixture
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

//importo le classi Entity e gli enum necessari
use TableCrown\Entity\ERecensione;
use TableCrown\Entity\ESegnalazione;
use TableCrown\Entity\EMotivazione;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\EPortaDadi;
use TableCrown\Entity\EBustine;

class RecensioneFixture extends AbstractFixture implements DependentFixtureInterface
{    
    // metodo obbligatorio che dice quali fixture devono essere caricate prima
    public function getDependencies(): array
    {
        return [UtenteFixture::class,
                GiocoDaTavoloFixture::class,
                PortaDadiFixture::class,
                BustineFixture::class,
        ];

    }

    private const NUM_RECENSIONI = 50;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        for ($i = 0; $i < self::NUM_RECENSIONI; $i++) {
            
            //prendiamo un utente random
            $utente = $this->getReference(
                'utente_' . $faker->numberBetween(0, 19), 
                EUtente::class
            );

            //scelgo un tipo di prodotto random
            $tipoProdotto = $faker->randomElement(['gioco', 'portadadi', 'bustine']);

            //pesco un prodotto random in base alla tipologia uscita prima
            if ($tipoProdotto === 'gioco') {
                $prodotto = $this->getReference('gioco_' . $faker->numberBetween(0, 9), EGiocoDaTavolo::class);
            } elseif ($tipoProdotto === 'portadadi') {
                $prodotto = $this->getReference('porta_dadi_' . $faker->numberBetween(0, 9), EPortaDadi::class);
            } else {
                $prodotto = $this->getReference('bustine_' . $faker->numberBetween(0, 9), EBustine::class);
            }

            //assegno un punteggio random al prodotto
            $valutazione = $faker->numberBetween(1, 5);
            //assegno un testo recensivo random al prodotto
            $testo = $faker->realText(150); 

            // creo la recensione
            $recensione = new ERecensione(
                $valutazione,
                $testo,
                $utente,
                $prodotto
            );

            //segnalo il 15% delle recensioni fatte
            if ($faker->boolean(15)) {
                //Peschiamo una motivazione casuale tra le motivazioni motivazione_0 ... motivazione_3
                $motivazione= $this->getReference('motivazione_' . $faker->numberBetween(0, 3), EMotivazione::class);
                $utenteSegnalante = $this->getReference('utente_' . $faker->numberBetween(0, 19), EUtente::class);
                $recensione->riceviSegnalazione(new ESegnalazione($motivazione, $recensione, $utenteSegnalante));
            }

            // salva riferimento per usarlo in altre fixture
            $this->addReference('recensione_' . $i, $recensione);
            //salva la traccia dell'entità nel IdentityMap e nella UnitOfWork
            $manager->persist($recensione);
        }
        //esegue le query appese nella UnitOfWork
        $manager->flush();
    }
}