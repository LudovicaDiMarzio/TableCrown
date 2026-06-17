<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

// Importiamo le Entity
use TableCrown\Entity\ECarrello;
use TableCrown\Entity\ECarrelloItem;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\EPortaDadi;
use TableCrown\Entity\EBustine;

class CarrelloFixture extends AbstractFixture implements DependentFixtureInterface
{
    // Creeremo un carrello per ciascuno dei 20 utenti
    private const NUM_UTENTI = 20;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        echo "Generazione dei carrelli della spesa in corso...\n";

        for ($i = 0; $i < self::NUM_UTENTI; $i++) {
            
            // 1. Peschiamo l'utente
            $utente = $this->getReference('utente_' . $i, EUtente::class);

            // 2. Creiamo il carrello di base per l'utente
            $carrello = new ECarrello($utente);

            // 3. Simuliamo il comportamento reale degli utenti:
            // Alcuni avranno il carrello vuoto (0), altri avranno fino a 3 prodotti.
            $numeroItems = $faker->numberBetween(0, 3);

            for ($j = 0; $j < $numeroItems; $j++) {
                
                // Peschiamo un tipo di prodotto a caso
                $tipoProdotto = $faker->randomElement(['gioco', 'portadadi', 'bustine']);

                if ($tipoProdotto === 'gioco') {
                    $prodotto = $this->getReference('gioco_' . $faker->numberBetween(0, 9), EGiocoDaTavolo::class);
                } elseif ($tipoProdotto === 'portadadi') {
                    $prodotto = $this->getReference('portadadi_' . $faker->numberBetween(0, 4), EPortaDadi::class);
                } else {
                    $prodotto = $this->getReference('bustine_' . $faker->numberBetween(0, 4), EBustine::class);
                }

                $quantita = $faker->numberBetween(1, 2);

                // Creiamo l'elemento del carrello
                $carrelloItem = new ECarrelloItem($quantita, $carrello, $prodotto);

                // Manteniamo la coerenza e aggiorniamo la data di ultima modifica
                $carrello->addCarrelloItem($carrelloItem);

                $manager->persist($carrelloItem);
            }

            // Salviamo il segnalibro
            $this->addReference('carrello_' . $i, $carrello);

            $manager->persist($carrello);
        }

        $manager->flush();
        echo "Carrelli della spesa creati e popolati con successo!\n";
    }

    /**
     * Il carrello ha bisogno degli utenti e di tutto il catalogo prodotti!
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