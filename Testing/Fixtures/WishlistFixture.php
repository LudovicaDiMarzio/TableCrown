<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

// Importiamo le Entity
use TableCrown\Entity\EWishlist;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\EPortaDadi;
use TableCrown\Entity\EBustine;

class WishlistFixture extends AbstractFixture implements DependentFixtureInterface
{
    private const NUM_UTENTI = 20;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        echo "Generazione delle liste dei desideri (Wishlist) in corso...\n";

        for ($i = 0; $i < self::NUM_UTENTI; $i++) {
            
            // 1. Peschiamo l'utente
            $utente = $this->getReference('utente_' . $i, EUtente::class);

            // 2. Creiamo la wishlist base per questo utente
            $wishlist = new EWishlist($utente);

            // 3. Quanti prodotti ha salvato l'utente? (Simuliamo da 0 a 5)
            $numeroPreferiti = $faker->numberBetween(0, 5);

            for ($j = 0; $j < $numeroPreferiti; $j++) {
                
                // Peschiamo un prodotto a caso (polimorfismo)
                $tipoProdotto = $faker->randomElement(['gioco', 'portadadi', 'bustine']);

                if ($tipoProdotto === 'gioco') {
                    $prodotto = $this->getReference('gioco_' . $faker->numberBetween(0, 9), EGiocoDaTavolo::class);
                } elseif ($tipoProdotto === 'portadadi') {
                    $prodotto = $this->getReference('portadadi_' . $faker->numberBetween(0, 4), EPortaDadi::class);
                } else {
                    $prodotto = $this->getReference('bustine_' . $faker->numberBetween(0, 4), EBustine::class);
                }

                // Aggiungiamo il prodotto alla wishlist. 
                // Se Faker dovesse pescare per sbaglio due volte lo stesso gioco nello stesso ciclo,
                // la tua classe EWishlist ignorerà il duplicato in automatico grazie al tuo "contains()"!
                $wishlist->addProdotto($prodotto);
            }

            // Mettiamo il segnalibro
            $this->addReference('wishlist_' . $i, $wishlist);

            $manager->persist($wishlist);
        }

        $manager->flush();
        echo "Wishlist create e popolate con successo!\n";
    }

    /**
     * La wishlist ha bisogno dell'utente e dell'intero catalogo prodotti!
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