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

    /**
     * Helper per caricare le immagini con la stessa logica di GiocoDaTavoloFixture.
     * Ritorna una stringa vuota come fallback per non far crashare il costruttore di EEvento (che richiede una string).
     */
    private function getImmagineBinaria(string $percorsoRelativo): string 
    {
        $percorsoImg = dirname(__DIR__, 2) . '/public/img/' . $percorsoRelativo;
        
        if (file_exists($percorsoImg) && is_file($percorsoImg)) {
            return file_get_contents($percorsoImg);
        }
        
        // Il costruttore di EEvento richiede strettamente una stringa, non possiamo passare null
        return ""; 
    }

    public function load(ObjectManager $manager): void 
    {
        $faker = Factory::create('it_IT');

        // 1. Carichiamo le immagini usando il path relativo corretto
        $imgSerata = $this->getImmagineBinaria('carousel/placeholder2.png');
        $imgTorneo = $this->getImmagineBinaria('carousel/placeholder2.png');
        $imgChallenge = $this->getImmagineBinaria('carousel/placeholder2.png');

        // ---------------------------------------------------------
        // 2. FIXTURE PER ESerata
        // ---------------------------------------------------------
        for ($i = 0; $i < 5; $i++) {
            $serata = new ESerata(
                "Serata " . $faker->words(3, true), 
                $imgSerata, 
                $faker->paragraph(), 
                $faker->dateTimeBetween('+1 days', '+2 weeks'), 
                $faker->numberBetween(10, 40), 
                $faker->randomElement(['Gioco libero', 'Presentazione', 'Torneo amatoriale']) 
            );
            
            $manager->persist($serata);
        }

        // ---------------------------------------------------------
        // 3. FIXTURE PER ETorneo (Singoli, non legati a Challenge)
        // ---------------------------------------------------------
        for ($i = 0; $i < 4; $i++) {
            
            $quotaTorneoSingolo = new EPrezzo(10.00, Valuta::EUR);

            do {
                $giocatoId = $faker->numberBetween(0, 19);
                $giocoDaGiocare = $this->getReference('gioco_' . $giocatoId, EGiocoDaTavolo::class);
            } while ($giocoDaGiocare->getDisponibilitaProdotto() !== DisponibilitaProdotto::Disponibile);

            $premioTorneoSingolo = $this->getRandomPremio($faker);

            $torneoSingolo = new ETorneo(
                "Torneo Singolo " . $faker->words(2, true), 
                $imgTorneo, 
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
        // 4. FIXTURE PER EChallenge (con i relativi tornei interni)
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
                    $imgTorneo, 
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
                $imgChallenge, 
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
