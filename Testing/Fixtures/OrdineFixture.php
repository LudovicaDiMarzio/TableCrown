<?php
namespace TableCrown\Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use DateTime;

use TableCrown\Entity\EOrdine;
use TableCrown\Entity\EOrdineItem;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\EProdotto;
use TableCrown\Entity\ECartaDiCredito;
use TableCrown\Entity\EIndirizzo;

class OrdineFixture extends AbstractFixture implements DependentFixtureInterface
{
    private const NUM_ORDINI = 10;

    public function getDependencies(): array
    {
        return [
            UtenteFixture::class,
            GiocoDaTavoloFixture::class,
            CartaDiCreditoFixture::class,  // ← serve per avere carte disponibili
            IndirizzoFixture::class,        // ← serve per avere indirizzi disponibili
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        $utenti = $manager->getRepository(EUtente::class)->findAll();
        $tuttiIProdotti = $manager->getRepository(EProdotto::class)->findAll();

        for ($i = 0; $i < self::NUM_ORDINI; $i++) {

            $utenteAcquirente = $faker->randomElement($utenti);

            // recuperiamo una carta che appartiene all'utente
            $carteUtente = $manager->getRepository(ECartaDiCredito::class)->findBy([
                'utente' => $utenteAcquirente
            ]);

            // se l'utente non ha carte, saltiamo
            if (empty($carteUtente)) {
                continue;
            }

            // recuperiamo un indirizzo che appartiene all'utente
            $indirizziUtente = $manager->getRepository(EIndirizzo::class)->findBy([
                'utente' => $utenteAcquirente
            ]);

            // se l'utente non ha indirizzi, saltiamo
            if (empty($indirizziUtente)) {
                continue;
            }

            $carta = $faker->randomElement($carteUtente);
            $indirizzo = $faker->randomElement($indirizziUtente);

            // creiamo l'ordine con utente, indirizzo e carta
            $ordine = new EOrdine($utenteAcquirente, $indirizzo, $carta);

            // aggiungiamo un numero casuale di prodotti all'ordine
            $numeroArticoli = $faker->numberBetween(1, 4);
            $prodottiUsati = []; // teniamo traccia dei prodotti già aggiunti

            for ($j = 0; $j < $numeroArticoli; $j++) {

                $prodotto = $faker->randomElement($tuttiIProdotti);

                // evitiamo di aggiungere lo stesso prodotto due volte
                if (in_array($prodotto->getIdProdotto(), $prodottiUsati)) {
                    continue;
                }

                $prodottiUsati[] = $prodotto->getIdProdotto();
                $quantita = $faker->numberBetween(1, 3);

                // EOrdineItem chiama $ordine->addOrdineItem($this) nel costruttore
                new EOrdineItem($quantita, $ordine, $prodotto);
            }

            // cambiamo lo stato ad alcuni ordini
            $dadoStato = $faker->numberBetween(1, 100);

            if ($dadoStato <= 30) {
                // 30% — spedito
                $ordine->spedisciOrdine();

            } elseif ($dadoStato <= 60) {
                // 30% — spedito e consegnato
                $ordine->spedisciOrdine();
                $ordine->consegnaOrdine();

            } elseif ($dadoStato > 90) {
                // 10% — annullato
                $ordine->annulla();
            }
            // 30% rimane IN_LAVORAZIONE

            $this->addReference('ordine_' . $i, $ordine);

            // gli item si salvano a cascata grazie al cascade: ["persist"] in EOrdine
            $manager->persist($ordine);
        }

        $manager->flush();
    }
}