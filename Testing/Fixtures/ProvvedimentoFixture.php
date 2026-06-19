<?php
// ProvvedimentoFixture.php
namespace TableCrown\Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use DateTime;
use TableCrown\Entity\EProvvedimento;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\ESegnalazione;
use TableCrown\Entity\Enumerativi\TipoProvvedimento;
use TableCrown\Entity\Enumerativi\StatoProvvedimento;

class ProvvedimentoFixture extends AbstractFixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            UtenteFixture::class,
            SegnalazioneFixture::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');
        $contatore = 0;

        // ─── Provvedimenti nati da segnalazioni ──────────────────────────
        $segnalazioni = $manager->getRepository(ESegnalazione::class)->findAll();

        foreach ($segnalazioni as $segnalazione) {

            // applichiamo il provvedimento solo all'80% delle segnalazioni
            if (!$faker->boolean(80)) {
                continue;
            }

            $utente = $segnalazione->getRecensione()->getUtente();
            $tipo = $faker->randomElement(TipoProvvedimento::cases());

            // data scadenza null di default — impostata solo per sospensioni
            $dataScadenza = null;
            if ($tipo === TipoProvvedimento::SOSPENSIONE) {
                $giorni = $faker->numberBetween(1, 30);
                $dataScadenza = (new DateTime())->modify("+$giorni days");
            }

            $provvedimento = new EProvvedimento(
                $tipo,
                $utente,
                $dataScadenza,
                null,           // nessuna recensione diretta
                $segnalazione   // segnalazione collegata
            );

            // ─── aggiorna stato utente solo se compatibile ───────────────
            try {
                if ($tipo === TipoProvvedimento::SOSPENSIONE) {
                    $utente->sospendi($dataScadenza);
                } else {
                    $utente->banna();
                }
            } catch (\DomainException $e) {
                // l'utente è già bannato o sospeso — saltiamo l'aggiornamento
                // il provvedimento viene comunque salvato come storico
            }



            // alcuni provvedimenti sono già revocati — simuliamo storico
            if ($faker->boolean(20)) {
                $provvedimento->revoca();
                $utente->riattiva();
            }

            $this->addReference('provvedimento_' . $contatore, $provvedimento);
            $manager->persist($provvedimento);
            $contatore++;
        }

        // ─── Provvedimenti diretti dall'admin (senza segnalazione) ───────
        $tuttiUtenti = $manager->getRepository(EUtente::class)->findAll();
        $utentiSanzionati = $faker->randomElements($tuttiUtenti, 3);

        foreach ($utentiSanzionati as $utente) {
            $tipo = $faker->randomElement(TipoProvvedimento::cases());

            $dataScadenza = null;
            if ($tipo === TipoProvvedimento::SOSPENSIONE) {
                $giorni = $faker->numberBetween(1, 30);
                $dataScadenza = (new DateTime())->modify("+$giorni days");
            }

            $provvedimento = new EProvvedimento(
                $tipo,
                $utente,
                $dataScadenza,
                null,   // nessuna recensione
                null    // nessuna segnalazione — provvedimento diretto
            );

            // ─── aggiorna stato utente solo se compatibile ───────────────
            try {
                if ($tipo === TipoProvvedimento::SOSPENSIONE) {
                    $utente->sospendi($dataScadenza);
                } else {
                    $utente->banna();
                }
            } catch (\DomainException $e) {
                // l'utente è già bannato o sospeso — saltiamo l'aggiornamento
                // il provvedimento viene comunque salvato come storico
            }

            // alcuni revocati
            if ($faker->boolean(20)) {
                $provvedimento->revoca();
                $utente->riattiva();
            }

            $this->addReference('provvedimento_' . $contatore, $provvedimento);
            $manager->persist($provvedimento);
            $contatore++;
        }

        $manager->flush();
    }
}