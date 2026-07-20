<?php
namespace TableCrown\Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

// Importo le classi necessarie
use TableCrown\Entity\EWishlist;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\EProdotto;
use TableCrown\Entity\EGiocoDaTavolo; // <-- Aggiunto
use TableCrown\Entity\EBustine;       // <-- Aggiunto
use TableCrown\Entity\EPortaDadi;     // <-- Aggiunto

class WishlistFixture extends AbstractFixture implements DependentFixtureInterface
{
    private const NUM_UTENTI = 20;

    public function getDependencies(): array
    {
        return [
            UtenteFixture::class,
            GiocoDaTavoloFixture::class,
            BustineFixture::class,
            PortaDadiFixture::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        for ($i = 0; $i < self::NUM_UTENTI; $i++) {
            
            // 1. Non tutti hanno una wishlist (70% di probabilità)
            if (!$faker->boolean(70)) {
                continue; 
            }

            /** @var EUtente $utente */
            $utente = $this->getReference('utente_' . $i, EUtente::class);

            $wishlist = new EWishlist($utente);

            // 2. Garantiamo prodotti MISTI.
            // Inseriamo SEMPRE almeno un Gioco da Tavolo
            $numGiochi = $faker->numberBetween(1, 3);
            for ($j = 0; $j < $numGiochi; $j++) {
                $randomId = $faker->numberBetween(0, 19);
                // CHIEDIAMO LA CLASSE ESATTA: EGiocoDaTavolo::class
                $gioco = $this->getReference('gioco_' . $randomId, EGiocoDaTavolo::class);
                $wishlist->addProdotto($gioco);
            }

            // Inseriamo SEMPRE almeno un accessorio (Bustina o Porta Dadi)
            if ($faker->boolean(50)) {
                $numBustine = $faker->numberBetween(1, 2);
                for ($j = 0; $j < $numBustine; $j++) {
                    $randomId = $faker->numberBetween(0, 9);
                    // CHIEDIAMO LA CLASSE ESATTA: EBustine::class
                    $bustina = $this->getReference('bustine_' . $randomId, EBustine::class);
                    $wishlist->addProdotto($bustina);
                }
            } else {
                $numPortaDadi = $faker->numberBetween(1, 2);
                for ($j = 0; $j < $numPortaDadi; $j++) {
                    $randomId = $faker->numberBetween(0, 9);
                    // CHIEDIAMO LA CLASSE ESATTA: EPortaDadi::class
                    $portaDadi = $this->getReference('porta_dadi_' . $randomId, EPortaDadi::class);
                    $wishlist->addProdotto($portaDadi);
                }
            }
            
            // Piccola chance extra (30%) di avere ENTRAMBI gli accessori
            if ($faker->boolean(30)) {
                $randomId = $faker->numberBetween(0, 9);
                $prodottoExtra = $faker->boolean() ? 
                    $this->getReference('bustine_' . $randomId, EBustine::class) : 
                    $this->getReference('porta_dadi_' . $randomId, EPortaDadi::class);
                
                $wishlist->addProdotto($prodottoExtra);
            }

            $manager->persist($wishlist);
        }

        $manager->flush();
    }
}