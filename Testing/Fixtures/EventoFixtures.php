<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

// Importiamo tutte le classi necessarie
use TableCrown\Entity\ESerata;
use TableCrown\Entity\ETorneo;
use TableCrown\Entity\EChallenge;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\EPortaDadi;
use TableCrown\Entity\EBustine;
use TableCrown\Entity\Enumerativi\Valuta;

class EventoFixture extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        echo "Generazione dell'ecosistema Eventi in corso...\n";

        // ==========================================
        // 1. GENERAZIONE SERATE (5 eventi)
        // ==========================================
        for ($i = 0; $i < 5; $i++) {
            // La data deve essere nel futuro (es. tra 1 settimana e 2 mesi da oggi)
            $dataInizio = $faker->dateTimeBetween('+1 week', '+2 months');
            
            $serata = new ESerata(
                "Serata " . $faker->catchPhrase(),                            // nome
                "assets/images/default_serata.png",                           // img
                $faker->paragraph(),                                          // descrizione
                $dataInizio,                                                  // data inizio
                $faker->numberBetween(10, 40),                                // max partecipanti
                $faker->randomElement(['Gioco Libero', 'Presentazione', 'A Tema']) // tipo serata
            );

            $this->addReference('serata_' . $i, $serata);
            $manager->persist($serata);
        }

        // ==========================================
        // 2. GENERAZIONE TORNEI (5 eventi)
        // ==========================================
        for ($i = 0; $i < 5; $i++) {
            $dataInizio = $faker->dateTimeBetween('+1 week', '+2 months');
            
            // Il torneo ha una quota di iscrizione (creata al volo in cascade)
            $quota = new EPrezzo($faker->randomFloat(2, 5, 20), Valuta::EUR, 0);
            
            // Il torneo si basa su un gioco specifico (peschiamo tra i 10 che abbiamo creato)
            $giocoDelTorneo = $this->getReference('gioco_' . $faker->numberBetween(0, 9), EGiocoDaTavolo::class);
            
            // Il premio (facciamo finta che si vinca un altro gioco da tavolo)
            $premio = $this->getReference('gioco_' . $faker->numberBetween(0, 9), EGiocoDaTavolo::class);

            $torneo = new ETorneo(
                "Torneo di " . $giocoDelTorneo->getNomeProdotto(),            // nome
                "assets/images/default_torneo.png",                           // img
                $faker->paragraph(),                                          // descrizione
                $dataInizio,                                                  // data inizio
                $faker->numberBetween(8, 16),                                 // max partecipanti
                $quota,                                                       // quota iscrizione
                $premio,                                                      // premio in palio
                $giocoDelTorneo                                               // gioco di riferimento
            );

            $this->addReference('torneo_' . $i, $torneo);
            $manager->persist($torneo);
        }

        // ==========================================
        // 3. GENERAZIONE CHALLENGE (5 eventi)
        // ==========================================
        for ($i = 0; $i < 5; $i++) {
            $dataInizio = $faker->dateTimeBetween('+1 week', '+2 months');
            
            $quota = new EPrezzo($faker->randomFloat(2, 2, 10), Valuta::EUR, 0);
            
            // Per variare, la Challenge ha come premio un Porta Dadi
            $premio = $this->getReference('portadadi_' . $faker->numberBetween(0, 4), EPortaDadi::class);

            // LOGICA DEI PUNTEGGI: Devono essere rigorosamente 1° > 2° > 3° per superare le tue validazioni!
            $punteggio1 = $faker->numberBetween(100, 150);
            $punteggio2 = $faker->numberBetween(50, 99);
            $punteggio3 = $faker->numberBetween(10, 49);

            $challenge = new EChallenge(
                "Challenge: " . $faker->word(),                               // nome
                "assets/images/default_challenge.png",                        // img
                $faker->paragraph(),                                          // descrizione
                $dataInizio,                                                  // data inizio
                $faker->numberBetween(20, 50),                                // max partecipanti
                $quota,                                                       // quota iscrizione
                $premio,                                                      // premio in palio
                $punteggio1,                                                  // punti 1° classificato
                $punteggio2,                                                  // punti 2° classificato
                $punteggio3                                                   // punti 3° classificato
            );

            $this->addReference('challenge_' . $i, $challenge);
            $manager->persist($challenge);
        }

        $manager->flush();
        echo "Eventi (Serate, Tornei e Challenge) generati e salvati con successo!\n";
    }

    /**
     * Visto che usiamo Giochi e Porta Dadi come premi e basi per i tornei,
     * i Prodotti devono essere caricati prima degli Eventi!
     */
    public function getDependencies(): array
    {
        return [
            GiocoDaTavoloFixture::class,
            PortaDadiFixture::class,
        ];
    }
}