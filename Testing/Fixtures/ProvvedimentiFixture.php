<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

// Importiamo le Entity
use TableCrown\Entity\EProvvedimento;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\ESegnalazione;
use TableCrown\Entity\ERecensione;

// Importiamo l'Enum
use TableCrown\Entity\Enumerativi\TipoProvvedimento;

class ProvvedimentoFixture extends AbstractFixture implements DependentFixtureInterface
{
    private const NUM_PROVVEDIMENTI = 15;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        echo "Generazione di " . self::NUM_PROVVEDIMENTI . " provvedimenti disciplinari in corso...\n";

        for ($i = 0; $i < self::NUM_PROVVEDIMENTI; $i++) {
            
            // 1. Peschiamo l'utente che verrà sanzionato (uno a caso tra i 20)
            $utenteSanzionato = $this->getReference(
                'utente_' . $faker->numberBetween(0, 19), 
                EUtente::class
            );

            // 2. Decidiamo il tipo di provvedimento (Sospensione o Ban)
            // Facciamo finta che i ban siano più rari (es. 20% di probabilità)
            $isBan = $faker->boolean(20);
            
            if ($isBan) {
                $tipo = TipoProvvedimento::BAN; // Sostituisci se nel tuo Enum si chiama diversamente
                $scadenza = null; // Il ban non ha scadenza
            } else {
                $tipo = TipoProvvedimento::SOSPENSIONE;
                // La sospensione deve avere una data futura! (da 1 a 30 giorni)
                $scadenza = $faker->dateTimeBetween('+1 days', '+30 days');
            }

            // 3. Decidiamo l'origine del provvedimento
            $segnalazioneCollegata = null;
            $recensioneCollegata = null;

            $origine = $faker->numberBetween(1, 3);
            if ($origine === 1) {
                // Origine 1: Nasce da una segnalazione (peschiamo tra le 30 generate)
                $segnalazioneCollegata = $this->getReference('segnalazione_' . $faker->numberBetween(0, 29), ESegnalazione::class);
            } elseif ($origine === 2) {
                // Origine 2: Nasce da una recensione tossica (peschiamo tra le 50 generate)
                $recensioneCollegata = $this->getReference('recensione_' . $faker->numberBetween(0, 49), ERecensione::class);
            }
            // Origine 3: Né recensione né segnalazione (l'admin ha agito di sua iniziativa)

            // 4. Creiamo il provvedimento rispettando il tuo costruttore
            $provvedimento = new EProvvedimento(
                $tipo,
                $utenteSanzionato,
                $scadenza,
                $recensioneCollegata,
                $segnalazioneCollegata
            );

            // 5. Tocco di realismo: magari un provvedimento è stato annullato per errore
            // Nel 10% dei casi simuliamo la revoca
            if ($faker->boolean(10)) {
                $provvedimento->revoca();
            }

            // Salviamo il segnalibro
            $this->addReference('provvedimento_' . $i, $provvedimento);

            $manager->persist($provvedimento);
        }

        $manager->flush();
        echo "Provvedimenti disciplinari creati e salvati con successo!\n";
    }

    /**
     * Il provvedimento dipende da un sacco di cose per poter essere creato!
     */
    public function getDependencies(): array
    {
        return [
            UtenteFixture::class,
            SegnalazioneFixture::class,
            RecensioneFixture::class,
        ];
    }
}