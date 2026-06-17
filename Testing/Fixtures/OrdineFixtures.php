<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

use TableCrown\Entity\EOrdine;
use TableCrown\Entity\EUtente;

class OrdineFixture extends AbstractFixture implements DependentFixtureInterface
{
    private const NUM_ORDINI = 40;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        echo "Generazione di " . self::NUM_ORDINI . " ordini in corso...\n";

        for ($i = 0; $i < self::NUM_ORDINI; $i++) {
            
            // 1. IL SEGNALIBRO: Peschiamo un utente a caso tra i 20 creati
            $utenteCasuale = $this->getReference(
                'utente_' . $faker->numberBetween(0, 19), 
                EUtente::class
            );

            // 2. Creiamo l'ordine (il costruttore lo imposterà di default 'in attesa')
            $ordine = new EOrdine($utenteCasuale);

            // 3. LOGICA DI DOMINIO: Simuliamo una cronologia realistica per il negozio
            // Generiamo un numero da 1 a 100 per creare delle percentuali
            $probabilita = $faker->numberBetween(1, 100);

            if ($probabilita <= 15) {
                // 15% dei casi: lo lasciamo 'in attesa'
            } elseif ($probabilita <= 30) {
                // 15% dei casi: confermato
                $ordine->confermato();
            } elseif ($probabilita <= 60) {
                // 30% dei casi: spedito
                $ordine->spedito();
            } elseif ($probabilita <= 90) {
                // 30% dei casi: già consegnato (utile per testare le Recensioni dopo!)
                $ordine->consegnato();
            } else {
                // 10% dei casi: annullato
                $ordine->annulla();
            }

            // 4. Salviamo il segnalibro! 
            // Questo è FONDAMENTALE perché ci servirà subito dopo per agganciarci gli OrdineItem
            $this->addReference('ordine_' . $i, $ordine);

            $manager->persist($ordine);
        }

        $manager->flush();
        echo "Ordini creati e salvati con successo!\n";
    }

    // Specifichiamo a Doctrine che deve caricare gli Utenti prima degli Ordini
    public function getDependencies(): array
    {
        return [
            UtenteFixture::class,
        ];
    }
}