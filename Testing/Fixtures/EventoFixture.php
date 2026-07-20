<?php
namespace TableCrown\Testing\Fixtures;

use Faker\Factory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use TableCrown\Entity\ESerata;
use TableCrown\Entity\ETorneo;
use TableCrown\Entity\EChallenge;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\EBustine;
use TableCrown\Entity\EPortaDadi;
use TableCrown\Entity\Enumerativi\Valuta;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;

class EventoFixture extends AbstractFixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            GiocoDaTavoloFixture::class,
            BustineFixture::class,
            PortaDadiFixture::class,
        ];
    }

    public function load(ObjectManager $manager): void 
    {
        $faker = Factory::create('it_IT');

        // ---------------------------------------------------------
        // 1. FIXTURE PER ESerata
        // ---------------------------------------------------------
        for ($i = 0; $i < 5; $i++) {
            $serata = new ESerata(
                "Serata " . $faker->words(3, true), 
                $faker->imageUrl(640, 480, 'nightlife'), 
                $faker->paragraph(), 
                $faker->dateTimeBetween('+1 days', '+2 weeks'), 
                $faker->numberBetween(10, 40), 
                $faker->randomElement(['Gioco libero', 'Presentazione', 'Torneo amatoriale']) 
            );
            
            $manager->persist($serata);
        }

        // ---------------------------------------------------------
        // 2. FIXTURE PER ETorneo (Singoli, non legati a Challenge)
        // ---------------------------------------------------------
        // Creiamo 4 tornei stand-alone
        for ($i = 0; $i < 4; $i++) {
            
            $quotaTorneoSingolo = new EPrezzo(10.00, Valuta::EUR);

            do {
                $giocatoId = $faker->numberBetween(0, 19);
                $giocoDaGiocare = $this->getReference('gioco_' . $giocatoId, EGiocoDaTavolo::class);
            } while ($giocoDaGiocare->getDisponibilitaProdotto() !== DisponibilitaProdotto::Disponibile);

            $premioTorneoSingolo = $this->getRandomPremio($faker);

            $torneoSingolo = new ETorneo(
                "Torneo Singolo " . $faker->words(2, true), 
                $faker->imageUrl(640, 480, 'sports'), 
                $faker->paragraph(), 
                $faker->dateTimeBetween('+1 month', '+2 months'), 
                $faker->numberBetween(8, 32), 
                $quotaTorneoSingolo,    
                $premioTorneoSingolo,   
                $giocoDaGiocare  
            );
            
            $manager->persist($torneoSingolo);
        }

        // ---------------------------------------------------------
        // 3. FIXTURE PER EChallenge (con i relativi tornei interni)
        // ---------------------------------------------------------
        for ($i = 0; $i < 3; $i++) {
            
            $torneiDellaChallenge = [];
            $numeroTornei = $faker->numberBetween(3, 7); 

            for ($j = 0; $j < $numeroTornei; $j++) {
                
                $quotaTorneo = new EPrezzo(15.00, Valuta::EUR);

                do {
                    $giocatoId = $faker->numberBetween(0, 19);
                    $giocoDaGiocare = $this->getReference('gioco_' . $giocatoId, EGiocoDaTavolo::class);
                } while ($giocoDaGiocare->getDisponibilitaProdotto() !== DisponibilitaProdotto::Disponibile);

                $premioTorneo = $this->getRandomPremio($faker);

                $torneo = new ETorneo(
                    "Torneo di Lega " . $faker->words(2, true), 
                    $faker->imageUrl(640, 480, 'sports'), 
                    $faker->paragraph(), 
                    $faker->dateTimeBetween('+2 months', '+4 months'), 
                    $faker->numberBetween(16, 64), 
                    $quotaTorneo,    
                    $premioTorneo,   
                    $giocoDaGiocare  
                );
                
                $torneiDellaChallenge[] = $torneo;
                $manager->persist($torneo);
            }

            $punteggioTerzo = $faker->numberBetween(10, 50);
            $punteggioSecondo = $faker->numberBetween($punteggioTerzo + 10, 100);
            $punteggioPrimo = $faker->numberBetween($punteggioSecondo + 10, 200);

            $quotaChallenge = new EPrezzo(20.00, Valuta::EUR);
            $premioChallenge = $this->getRandomPremio($faker);

            $challenge = new EChallenge(
                "Challenge " . $faker->words(2, true), 
                $faker->imageUrl(640, 480, 'trophy'), 
                $faker->paragraph(), 
                $faker->dateTimeBetween('+4 months', '+6 months'), 
                $faker->numberBetween(50, 150), 
                $quotaChallenge,   
                $premioChallenge,  
                $punteggioPrimo, 
                $punteggioSecondo, 
                $punteggioTerzo, 
                $torneiDellaChallenge 
            );

            $manager->persist($challenge);
        }

        $manager->flush();
    }

    /**
     * Funzione di appoggio per estrarre causalmente dal database
     * un premio misto tra Giochi, Bustine e Porta Dadi,
     * garantendo che lo stato sia Disponibile.
     */
    private function getRandomPremio(\Faker\Generator $faker)
    {
        do {
            $tipoPremio = $faker->randomElement(['gioco', 'bustine', 'porta_dadi']);

            if ($tipoPremio === 'gioco') {
                $randomId = $faker->numberBetween(0, 19);
                $premio = $this->getReference('gioco_' . $randomId, EGiocoDaTavolo::class);
                
            } elseif ($tipoPremio === 'bustine') {
                $randomId = $faker->numberBetween(0, 9);
                $premio = $this->getReference('bustine_' . $randomId, EBustine::class);
                
            } else {
                $randomId = $faker->numberBetween(0, 9);
                $premio = $this->getReference('porta_dadi_' . $randomId, EPortaDadi::class);
            }
            
        } while ($premio->getDisponibilitaProdotto() !== DisponibilitaProdotto::Disponibile);

        return $premio;
    }
}