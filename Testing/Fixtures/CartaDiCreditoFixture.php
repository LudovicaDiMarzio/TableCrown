<?php
// CartaDiCreditoFixture.php
namespace TableCrown\Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use DateTime;
use TableCrown\Entity\ECartaDiCredito;
use TableCrown\Entity\EUtente;

class CartaDiCreditoFixture extends AbstractFixture implements DependentFixtureInterface
{
    private const NUM_CARTE_PER_UTENTE = 1; // ogni utente ha 1 carta
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

        // ogni utente ha un numero casuale di carte tra 1 e 3
        $numCarte = $faker->numberBetween(1, 3);

        for ($j = 0; $j < $numCarte; $j++) {

            $dataScadenza = new DateTime();
            $dataScadenza->modify('+' . $faker->numberBetween(1, 5) . ' years');

            $carta = new ECartaDiCredito(
                $utente,
                $faker->name(),
                $faker->dateTimeBetween('+1 month', '+5 years')->format('m/y'),
                $faker->numerify('####'),
                'tok_' . bin2hex(random_bytes(8))
                
            );

            $this->addReference('carta_' . $contatore, $carta);
            $manager->persist($carta);
            $contatore++;
        }
    }

        $manager->flush();
    }
}