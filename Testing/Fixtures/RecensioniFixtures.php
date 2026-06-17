<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

use TableCrown\Entity\ERecensione;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\EPortaDadi;
use TableCrown\Entity\EBustine;

class RecensioneFixture extends AbstractFixture implements DependentFixtureInterface
{
    private const NUM_RECENSIONI = 50;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        echo "Generazione di " . self::NUM_RECENSIONI . " recensioni collegate ai prodotti...\n";

        for ($i = 0; $i < self::NUM_RECENSIONI; $i++) {
            
            // 1. Peschiamo un utente a caso
            $utenteCasuale = $this->getReference(
                'utente_' . $faker->numberBetween(0, 19), 
                EUtente::class
            );

            // 2. Peschiamo un PRODOTTO a caso (polimorfismo in azione!)
            $tipoProdotto = $faker->randomElement(['gioco', 'portadadi', 'bustine']);

            if ($tipoProdotto === 'gioco') {
                $prodottoCasuale = $this->getReference('gioco_' . $faker->numberBetween(0, 9), EGiocoDaTavolo::class);
            } elseif ($tipoProdotto === 'portadadi') {
                $prodottoCasuale = $this->getReference('portadadi_' . $faker->numberBetween(0, 4), EPortaDadi::class);
            } else {
                $prodottoCasuale = $this->getReference('bustine_' . $faker->numberBetween(0, 4), EBustine::class);
            }

            $valutazione = $faker->numberBetween(1, 5);
            $testo = $faker->realText(150); 

            // 3. Creiamo la recensione con tutti e 4 i parametri corretti
            $recensione = new ERecensione(
                $valutazione,
                $testo,
                $utenteCasuale,
                $prodottoCasuale
            );

            if ($faker->boolean(15)) {
                $recensione->segnala();
            }

            $this->addReference('recensione_' . $i, $recensione);

            $manager->persist($recensione);
        }

        $manager->flush();
        echo "Recensioni create e salvate con successo!\n";
    }

    /**
     * Ora la fixture dipende sia dagli utenti che dai prodotti!
     */
    public function getDependencies(): array
    {
        return [
            UtenteFixture::class,
            GiocoDaTavoloFixture::class,
            PortaDadiFixture::class,
            BustineFixture::class,
        ];
    }
}