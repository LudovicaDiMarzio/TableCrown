<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

// Importiamo tutte le classi necessarie
use TableCrown\Entity\EOrdineItem;
use TableCrown\Entity\EOrdine;
use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\EPortaDadi;
use TableCrown\Entity\EBustine;

class OrdineItemFixture extends AbstractFixture implements DependentFixtureInterface
{
    // Sappiamo che abbiamo generato 40 ordini in OrdineFixture
    private const NUM_ORDINI = 40;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        echo "Riempimento degli ordini con prodotti in corso...\n";

        // Cicliamo su OGNI ordine esistente
        for ($i = 0; $i < self::NUM_ORDINI; $i++) {
            
            // Ripeschiamo l'ordine corrente
            $ordineCasuale = $this->getReference('ordine_' . $i, EOrdine::class);

            // Decidiamo quanti prodotti diversi ci sono in questo ordine (da 1 a 3)
            $numeroProdottiNelCarrello = $faker->numberBetween(1, 3);

            for ($j = 0; $j < $numeroProdottiNelCarrello; $j++) {
                
                // Peschiamo un tipo di prodotto a caso (Gioco, PortaDadi o Bustine)
                $tipoProdotto = $faker->randomElement(['gioco', 'portadadi', 'bustine']);

                if ($tipoProdotto === 'gioco') {
                    // Ricorda: avevamo creato 10 giochi (da 0 a 9)
                    $prodotto = $this->getReference('gioco_' . $faker->numberBetween(0, 9), EGiocoDaTavolo::class);
                } elseif ($tipoProdotto === 'portadadi') {
                    // Avevamo creato 5 porta dadi (da 0 a 4)
                    $prodotto = $this->getReference('portadadi_' . $faker->numberBetween(0, 4), EPortaDadi::class);
                } else {
                    // Avevamo creato 5 bustine (da 0 a 4)
                    $prodotto = $this->getReference('bustine_' . $faker->numberBetween(0, 4), EBustine::class);
                }

                // Generiamo una quantità per questo specifico prodotto (es. ne compro 1 o 2)
                $quantita = $faker->numberBetween(1, 2);

                // Creiamo l'Item passando tutti e 3 i parametri al tuo costruttore
                $ordineItem = new EOrdineItem($quantita, $ordineCasuale, $prodotto);

                // IMPORTANTE: Manteniamo la coerenza bidirezionale aggiungendolo all'ordine
                $ordineCasuale->addOrdineItem($ordineItem);

                $manager->persist($ordineItem);
            }
        }

        $manager->flush();
        echo "Tutti gli ordini sono stati riempiti con i prodotti con successo!\n";
    }

    /**
     * Dobbiamo assicurarci che Ordini e TUTTI i Prodotti 
     * esistano prima di lanciare questo file!
     */
    public function getDependencies(): array
    {
        return [
            OrdineFixture::class,
            GiocoDaTavoloFixture::class,
            PortaDadiFixture::class,
            BustineFixture::class,
        ];
    }
}