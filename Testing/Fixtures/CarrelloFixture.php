<?php
namespace TableCrown\Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

// Importiamo le Entity
use TableCrown\Entity\ECarrello;
use TableCrown\Entity\ECarrelloItem;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\EProdotto;
use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\EPortaDadi;
use TableCrown\Entity\EBustine;

class CarrelloFixture extends AbstractFixture implements DependentFixtureInterface
{
     // metodo obbligatorio che dice quali fixture devono essere caricate prima
    public function getDependencies(): array
    {
        return [
            UtenteFixture::class,
            GiocoDaTavoloFixture::class,
            BustineFixture::class,
            PortaDadiFixture::class
        ];
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');
        
        //mi seleziono tutti gli utenti e i prodotti
        $utenti = $manager->getRepository(EUtente::class)->findAll();
        $tuttiIProdotti = $manager->getRepository(EProdotto::class)->findAll();
        $contatore=0;

        foreach ($utenti as $utente) {
            //creo il carrello di base per l'utente
            $carrello = new ECarrello($utente);

            $numeroArticoli = $faker->numberBetween(1, 4);
            for ($j = 0; $j < $numeroArticoli; $j++) {
            
                // Peschiamo un prodotto a caso e decidiamo la quantità
                $prodotto = $faker->randomElement($tuttiIProdotti);
                $quantita = $faker->numberBetween(1, 3);

                // Creiamo l'Item di quel prodotto nel carrello
                $item = new ECarrelloItem( $quantita, $carrello, $prodotto);

                // 4. Lo aggiungiamo al carrello
                $carrello->addCarrelloItem($item); 
            }




            // Salviamo il segnalibro
            $this->addReference('carrello_' . $contatore, $carrello);

            $manager->persist($carrello);
            $contatore++;
        }

        $manager->flush();
    }

}