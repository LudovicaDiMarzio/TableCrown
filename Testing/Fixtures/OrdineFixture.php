<?php
namespace TableCrown\Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

use TableCrown\Entity\EOrdine;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\EProdotto;
use TableCrown\Entity\EOrdineItem;

//creiamo le fixtures per l'ordine che saranno collegate direttamente con il rispettivo item grazie al cascade presente nell'entity
class OrdineFixture extends AbstractFixture implements DependentFixtureInterface
{
   

    public function getDependencies(): array
    {
        // Ci servono gli utenti per comprare e i prodotti da mettere nell'ordine!
        return [
            UtenteFixture::class,
            GiocoDaTavoloFixture::class, // (O la fixture generica dei prodotti se ne hai una)
        ];
    }
    private const NUM_ORDINI = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        // Peschiamo tutti gli utenti e tutti i prodotti 
        $utenti = $manager->getRepository(EUtente::class)->findAll();
        $tuttiIProdotti = $manager->getRepository(EProdotto::class)->findAll();

        // Facciamo fare un acquisto a NUM_ORDINI utenti casuali 
        for ($i = 0; $i < self::NUM_ORDINI; $i++) {
            
            $utenteAcquirente = $faker->randomElement($utenti);
            
            // creazione ordine base
            $ordine = new EOrdine($utenteAcquirente);

            // scegliamo un numero casuale di articoli da acquistare
            $numeroArticoli = $faker->numberBetween(1, 4);

            for ($j = 0; $j < $numeroArticoli; $j++) {
                
                $prodotto = $faker->randomElement($tuttiIProdotti);
                $quantita = $faker->numberBetween(1, 3);

                // creazione item ordine
                $item = new EOrdineItem($quantita, $ordine, $prodotto);
                
                //aggiunta dell'item all'ordine
                $ordine->addOrdineItem($item); 
            }

            //creo stati diversi per alcuni ordini (L'ordine è nato IN_LAVORAZIONE.)
            
            //  Tiriamo un dado per cambiare lo stato ad alcuni di loro.
            $dadoStato = $faker->numberBetween(1, 100);
            //non usiamo la funzione boolean di faker perchè andrebbe a rimpicciolire la percentuale di volta in volta
            if ($dadoStato <= 30) {
                // 30% dei casi: L'ordine è stato spedito
                $ordine->spedisciOrdine();
                
            } elseif ($dadoStato > 30 && $dadoStato <= 60) {
                // 30% dei casi: L'ordine è stato spedito E poi consegnato!
                $ordine->spedisciOrdine();
                $ordine->consegnaOrdine();
                
            } elseif ($dadoStato > 90) {
                // 10% dei casi: L'ordine è stato annullato subito
                $ordine->annulla();
            }
            // Il restante 30% rimarrà IN_LAVORAZIONE (come appena nato)

            // 5. Salviamo l'Ordine (gli item si salveranno a cascata!)
            $manager->persist($ordine);
        }

        $manager->flush();
    }
}