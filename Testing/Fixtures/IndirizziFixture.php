<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

use TableCrown\Entity\EIndirizzo;
use TableCrown\Entity\EUtente;

class IndirizzoFixture extends AbstractFixture implements DependentFixtureInterface
{
    private const NUM_UTENTI = 20;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        echo "Generazione degli indirizzi di spedizione in corso...\n";

        // Cicliamo su tutti i 20 utenti per assicurarci che ognuno abbia almeno un indirizzo
        for ($i = 0; $i < self::NUM_UTENTI; $i++) {
            
            $utente = $this->getReference('utente_' . $i, EUtente::class);

            // Decidiamo a caso se l'utente ha 1 o 2 indirizzi salvati (es. "Casa" e "Lavoro")
            $numeroIndirizzi = $faker->numberBetween(1, 2);
            $tipiIndirizzo = ['Casa', 'Ufficio', 'Casa Mare', 'Lavoro', 'Studio'];

            for ($j = 0; $j < $numeroIndirizzi; $j++) {
                
                // Usiamo numerify('#####') per garantire che il CAP sia ESATTAMENTE di 5 cifre
                // altrimenti la tua regex nel costruttore potrebbe andare in errore!
                $cap = $faker->numerify('#####');

                $indirizzo = new EIndirizzo(
                    $faker->randomElement($tipiIndirizzo), // nome (es. "Casa")
                    $faker->streetAddress(),               // via (es. "Via Roma 10")
                    $faker->city(),                        // citta
                    $cap,                                  // cap a 5 cifre
                    $faker->stateAbbr(),                   // provincia (es. "RM", "AQ")
                    "Italia",                              // nazione (fissata per semplicità)
                    $faker->lastName(),                    // nomeCitofono
                    $utente                                // l'EUtente proprietario
                );

                // Salviamo un segnalibro univoco per ogni indirizzo 
                // (es. "indirizzo_0_0", "indirizzo_0_1")
                $this->addReference('indirizzo_' . $i . '_' . $j, $indirizzo);

                $manager->persist($indirizzo);
            }
        }

        $manager->flush();
        echo "Indirizzi creati e salvati con successo!\n";
    }

    /**
     * Gli indirizzi dipendono dagli Utenti!
     */
    public function getDependencies(): array
    {
        return [
            UtenteFixture::class,
        ];
    }
}