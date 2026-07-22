<?php
namespace TableCrown\Fixture;

use Faker\Factory;
use TableCrown\Entity\ESerata;
use TableCrown\Entity\ETorneo;
use TableCrown\Entity\EChallenge;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\EGiocoDaTavolo;
use tablecrown\Entity\Enumerativi\Valuta;
use TableCrown\Entity\EDanno;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
use TableCrown\Entity\Enumerativi\DifficoltaGioco;
use TableCrown\Entity\Enumerativi\LinguaGioco;

// use TableCrown\Foundation\FEntityManager;

class EventiFixture
{
    public static function loadFixtures(): void
    {
        $faker = Factory::create('it_IT');
        
        // $em = FEntityManager::getInstance()->getEntityManager();

        // ---------------------------------------------------------
        // 1. PREPARAZIONE DIPENDENZE (Premi, Giochi, Quote)
        // ---------------------------------------------------------
        
        // Creiamo una quota da riutilizzare
        $quotaStandard = new EPrezzo(15.00, Valuta::EUR);
        // $em->persist($quotaStandard);

        // Creiamo un EGiocoDaTavolo valido secondo il nuovo costruttore
        // ATTENZIONE: i casi degli Enum (es. ::Facile, ::Italiano) devono esistere nei tuoi file!
        $giocoPremio = new EGiocoDaTavolo(
            "Gioco Faker " . $faker->word(),          // string $nomeProdotto
            $faker->paragraph(),                      // string $descrizioneProdotto
            DisponibilitaProdotto::Disponibile,       // DisponibilitaProdotto $disponibilitaProdotto
            10,                                       // int $quantita
            ['Avventura', 'Strategia'],               // array $categoria
            ['Tabellone', 'Carte', 'Dadi'],           // array $componenti
            DifficoltaGioco::Facile,                  // DifficoltaGioco $difficolta (sostituisci col tuo caso reale)
            LinguaGioco::Italiano,                    // LinguaGioco $lingua (sostituisci col tuo caso reale)
            $faker->imageUrl(640, 480, 'abstract'),   // ?string $imgProdotto
            $quotaStandard,                           // ?EPrezzo $prezzo
            null,                                     // ?EGiocoDaTavolo $giocoBase (null perché è un gioco base)
            2,                                        // int $numeroGiocatoriMin
            4,                                        // int $numeroGiocatoriMax
            10,                                       // int $etaMinima
            60,                                       // int $durataMedia
            null,                                     // ?EDanno $danno
            null                                      // ?string $descrizioneDanno
        );
        // $em->persist($giocoPremio);

        // ---------------------------------------------------------
        // 2. FIXTURE PER ESerata
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
            
            // $em->persist($serata);
        }

        // ---------------------------------------------------------
        // 3. FIXTURE PER ETorneo e EChallenge
        // ---------------------------------------------------------
        for ($i = 0; $i < 3; $i++) {
            
            $torneiDellaChallenge = [];
            // Genero un numero casuale di tornei valido per la challenge (tra 3 e 7)
            $numeroTornei = $faker->numberBetween(3, 7); 

            for ($j = 0; $j < $numeroTornei; $j++) {
                $torneo = new ETorneo(
                    "Torneo " . $faker->words(2, true), 
                    $faker->imageUrl(640, 480, 'sports'), 
                    $faker->paragraph(), 
                    $faker->dateTimeBetween('+1 month', '+3 months'), 
                    $faker->numberBetween(16, 64), 
                    $quotaStandard, // quotaIscrizione
                    $giocoPremio,   // premio (supera verificaPremio perché l'abbiamo messo Disponibile)
                    $giocoPremio    // gioco su cui si gioca
                );
                
                $torneiDellaChallenge[] = $torneo;
                // $em->persist($torneo);
            }

            // Calcolo punteggi per superare verificaPunteggi() in sicurezza (P1 > P2 > P3 > 0)
            $punteggioTerzo = $faker->numberBetween(10, 50);
            $punteggioSecondo = $faker->numberBetween($punteggioTerzo + 10, 100);
            $punteggioPrimo = $faker->numberBetween($punteggioSecondo + 10, 200);

            // Creo la Challenge passando l'array di tornei e i punteggi validi
            $challenge = new EChallenge(
                "Challenge " . $faker->words(2, true), 
                $faker->imageUrl(640, 480, 'trophy'), 
                $faker->paragraph(), 
                $faker->dateTimeBetween('+4 months', '+6 months'), 
                $faker->numberBetween(50, 150), 
                $quotaStandard, 
                $giocoPremio, 
                $punteggioPrimo, 
                $punteggioSecondo, 
                $punteggioTerzo, 
                $torneiDellaChallenge 
            );

            // $em->persist($challenge);
        }

        // $em->flush();
    }
}