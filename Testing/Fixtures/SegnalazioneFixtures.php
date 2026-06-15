<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface; // <-- LA NOVITÀ!
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

use TableCrown\Entity\ESegnalazione;
use TableCrown\Entity\EUtente;        // <-- Aggiungi questa
use TableCrown\Entity\EMotivazione;

// Aggiungiamo 'implements DependentFixtureInterface' per gestire l'ordine di esecuzione
class SegnalazioneFixture extends AbstractFixture implements DependentFixtureInterface
{
    private const NUM_SEGNALAZIONI = 30;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        echo "Generazione di " . self::NUM_SEGNALAZIONI . " segnalazioni in corso...\n";

        for ($i = 0; $i < self::NUM_SEGNALAZIONI; $i++) {
            
            // 1. LA MAGIA DEI SEGNALIBRI: Peschiamo un utente e una motivazione a caso
            // Sappiamo che abbiamo creato 20 utenti (da 0 a 19) e 5 motivazioni (da 0 a 4)
            $utenteCasuale = $this->getReference(
                'utente_' . $faker->numberBetween(0, 19), 
                EUtente::class
            );

            $motivazioneCasuale = $this->getReference(
                'motivazione_' . $faker->numberBetween(0, 4), 
                EMotivazione::class
            );

            // 2. Creiamo la segnalazione passandogli gli oggetti VERIC che abbiamo appena ripescato
            $segnalazione = new ESegnalazione(
                $motivazioneCasuale, 
                $utenteCasuale
            );

            // 3. Tocco di realismo: il costruttore la imposta "IN_ATTESA", 
            // ma facciamo finta che circa il 40% delle segnalazioni siano già state "risolte" dall'admin
            if ($faker->boolean(40)) {
                $segnalazione->risolvi();
            }

            // Salviamo un segnalibro anche qui, metti caso ci servisse per i Provvedimenti
            $this->addReference('segnalazione_' . $i, $segnalazione);

            $manager->persist($segnalazione);
        }

        $manager->flush();
        echo "Segnalazioni create e salvate con successo!\n";
    }

    /**
     * Questo metodo è obbligatorio quando si usa DependentFixtureInterface.
     * Dice a Doctrine: "Ehi, prima di eseguire questo file, ASSICURATI 
     * di aver già eseguito questi altri due!"
     */
    public function getDependencies(): array
    {
        return [
            UtenteFixture::class,
            MotivazioneFixture::class,
        ];
    }
}