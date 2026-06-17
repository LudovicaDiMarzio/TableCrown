<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

use TableCrown\Entity\EPartecipazione;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\EEvento;

class PartecipazioneFixture extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        echo "Iscrizione degli utenti agli eventi in corso...\n";

        // SOLUZIONE INFALLIBILE: Chiediamo a Doctrine di pescare TUTTI gli 
        // eventi direttamente dalla tabella del database, bypassando le Reference!
        $tuttiGliEventi = $manager->getRepository(EEvento::class)->findAll();

        // Cicliamo su ogni evento reale trovato nel database
        foreach ($tuttiGliEventi as $evento) {
            
            // Decidiamo a caso quanti utenti partecipano a questo evento
            $maxPossibili = min(10, $evento->getMaxPartecipanti());
            $numeroIscritti = $faker->numberBetween(3, $maxPossibili);

            // Peschiamo degli ID utente univoci (sappiamo che ci sono 20 utenti salvati correttamente)
            $utentiIds = $faker->randomElements(range(0, 19), $numeroIscritti);

            foreach ($utentiIds as $userId) {
                // Per gli utenti possiamo usare i segnalibri perché sappiamo che funzionano perfettamente
                $utente = $this->getReference('utente_' . $userId, EUtente::class);

                // Simuliamo il pagamento
                $quotaPagata = false;
                if ($evento->richiedeQuota()) {
                    $quotaPagata = $faker->boolean(80);
                }

                $partecipazione = new EPartecipazione(
                    $utente,
                    $evento,
                    null,          // Posizione iniziale
                    null,          // Punteggio iniziale
                    $quotaPagata   // Pagamento
                );

                // Coerenza bidirezionale
                $evento->addPartecipazione($partecipazione);

                $manager->persist($partecipazione);
            }
        }

        $manager->flush();
        echo "Partecipazioni create e salvate con successo!\n";
    }

    public function getDependencies(): array
    {
        return [
            UtenteFixture::class,
            EventoFixture::class,
        ];
    }
}