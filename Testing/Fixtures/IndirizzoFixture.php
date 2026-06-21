<?php
// IndirizzoFixture.php
namespace TableCrown\Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use TableCrown\Entity\EIndirizzo;
use TableCrown\Entity\EUtente;

class IndirizzoFixture extends AbstractFixture implements DependentFixtureInterface
{
    private const NUM_INDIRIZZI_PER_UTENTE = 2; // ogni utente ha 2 indirizzi
    private const NUM_UTENTI = 20;

    public function getDependencies(): array
    {
        return [UtenteFixture::class];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');
        $contatore = 0;

    for ($i = 0; $i < self::NUM_UTENTI; $i++) {

        $utente = $this->getReference('utente_' . $i, EUtente::class);

        // ogni utente ha un numero casuale di indirizzi tra 1 e 3
        $numIndirizzi = $faker->numberBetween(1, 3);

        for ($j = 0; $j < $numIndirizzi; $j++) {

            $indirizzo = new EIndirizzo(
                $faker->words(2, true),
                $faker->streetAddress(),
                $faker->city(),
                $faker->numerify('#####'),
                $faker->state(),
                'Italia',
                $faker->lastName(),
                $utente
            );

            $this->addReference('indirizzo_' . $contatore, $indirizzo);
            $manager->persist($indirizzo);
            $contatore++;
        }
    }

        $manager->flush();
    }
}