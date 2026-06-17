<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

use TableCrown\Entity\ECartaDiCredito;
use TableCrown\Entity\EUtente;

class CartaDiCreditoFixture extends AbstractFixture implements DependentFixtureInterface
{
    private const NUM_CARTE = 25;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        echo "Generazione di " . self::NUM_CARTE . " carte di credito in corso...\n";

        for ($i = 0; $i < self::NUM_CARTE; $i++) {
            
            // 1. IL SEGNALIBRO: Peschiamo un utente a caso (tra 0 e 19)
            $utenteCasuale = $this->getReference(
                'utente_' . $faker->numberBetween(0, 19), 
                EUtente::class
            );

            // 2. Generiamo i dati rispettando alla lettera le tue Regex
            // numerify('################') garantisce ESATTAMENTE 16 cifre attaccate
            $numeroCarta = $faker->numerify('################'); 
            
            // numerify('###') garantisce ESATTAMENTE 3 cifre
            $ccv = $faker->numerify('###');

            // dateTimeBetween('+1 month', '+4 years') garantisce una data nel futuro
            $dataScadenza = $faker->dateTimeBetween('+1 month', '+4 years');

            // 3. Creiamo la carta di credito
            $carta = new ECartaDiCredito(
                $faker->firstName(),        // nomeTitolare
                $faker->lastName(),         // cognomeTitolare
                $dataScadenza,              // dataScadenza (futura!)
                $numeroCarta,               // numero (16 cifre pure)
                $ccv,                       // ccv (3 cifre pure)
                $utenteCasuale              // L'utente proprietario
            );

            // Mettiamo il segnalibro! 
            $this->addReference('cartadicredito_' . $i, $carta);

            $manager->persist($carta);
        }

        $manager->flush();
        echo "Carte di credito generate e salvate con successo!\n";
    }

    /**
     * Le carte di credito hanno bisogno dell'utente per esistere!
     */
    public function getDependencies(): array
    {
        return [
            UtenteFixture::class,
        ];
    }
}