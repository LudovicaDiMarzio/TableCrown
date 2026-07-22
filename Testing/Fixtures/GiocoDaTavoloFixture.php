<?php
namespace TableCrown\Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use ReflectionProperty;

use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\EDanno;
use TableCrown\Entity\Enumerativi\Valuta;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
use TableCrown\Entity\Enumerativi\Categoria;
use TableCrown\Entity\Enumerativi\DifficoltaGioco;
use TableCrown\Entity\Enumerativi\LinguaGioco;

class GiocoDaTavoloFixture extends AbstractFixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [DannoFixture::class];
    }

    private const NUM_GIOCHI_RANDOM = 20;

    /**
     * Forza il valore di una proprietà privata/protetta via Reflection.
     * Serve per dataPubblicazione e valutazioneMedia, che non hanno un setter
     * pubblico utilizzabile per popolare dati di test coerenti con i filtri
     * (vedi nota sul bug di getValutazioneMedia() nella spiegazione sopra).
     */
    private function setProtectedProperty(object $obj, string $property, $value): void
        {
            $reflectionClass = new \ReflectionClass($obj);
            
            // Risale la gerarchia (es. da EGiocoDaTavolo a EProdotto) se la proprietà non è nella classe corrente
            while (!$reflectionClass->hasProperty($property) && $reflectionClass = $reflectionClass->getParentClass()) {
                // Continua a salire
            }

            // Se non la trova nemmeno nel genitore, lancia un errore descrittivo
            if (!$reflectionClass) {
                throw new \Exception("ATTENZIONE: La proprietà '$property' non esiste in " . get_class($obj) . " né nelle sue classi genitore. Controlla il nome esatto della variabile nell'Entity!");
            }

            $prop = $reflectionClass->getProperty($property);
            $prop->setAccessible(true);
            $prop->setValue($obj, $value);
        }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        $percorsoImg = dirname(__DIR__, 2) . '/public/img/img1.png'; // adatta il path relativo alla tua struttura cartelle

        $immaginePredefinita = null;
        if (file_exists($percorsoImg) && is_file($percorsoImg)) {
            $immaginePredefinita = file_get_contents($percorsoImg);
        } else {
            // Fallback: se il file non c'è, niente immagine (null), invece di un URL esterno
            // che romperebbe la logica base64 usata in tutto il resto del progetto.
            $immaginePredefinita = null;
        }

        $componentiDisponibili = [
            'Tabellone', 'Carte', 'Pedine', 'Dadi',
            'Segnalini', 'Token', 'Plance giocatore'
        ];

        // helper per creare un gioco con parametri random, ma con la possibilità
        // di forzare (override) i valori necessari a coprire i filtri di FGiocoDaTavolo
        $creaGioco = function (array $overrides = []) use ($faker, $componentiDisponibili, $immaginePredefinita): EGiocoDaTavolo {

            $categorieEnum = $faker->randomElements(Categoria::cases(), $faker->numberBetween(1, 3));
            $categorieTesto = array_map(fn($cat) => $cat->value, $categorieEnum);

            $componenti = $faker->randomElements($componentiDisponibili, $faker->numberBetween(2, 5));

            $valorePrezzo = $overrides['prezzo'] ?? $faker->randomFloat(2, 2, 60);
            $prezzo = new EPrezzo($valorePrezzo, Valuta::EUR);

            $disponibilita = $overrides['disponibilita'] ?? $faker->randomElement(DisponibilitaProdotto::cases());
            if ($disponibilita === DisponibilitaProdotto::Esaurito) {
                $quantita = 0;
            } else {
                $quantita = $overrides['quantita'] ?? $faker->numberBetween(10, 100);
            }
            $giocatoriMin = $overrides['giocatoriMin'] ?? $faker->numberBetween(1, 4);
            $giocatoriMax = $overrides['giocatoriMax'] ?? $faker->numberBetween($giocatoriMin, $giocatoriMin + 4);
            $etaMinima = $overrides['etaMinima'] ?? $faker->randomElement([6, 8, 10, 12, 14, 16, 18]);
            $durataMedia = $overrides['durataMedia'] ?? $faker->numberBetween(15, 180);

            $gioco = new EGiocoDaTavolo(
                $overrides['nome'] ?? $faker->words(3, true),
                $faker->paragraph(),
                $disponibilita,
                $quantita,
                categoria: $categorieTesto,
                componenti: $componenti,
                difficolta: $overrides['difficolta'] ?? $faker->randomElement(DifficoltaGioco::cases()),
                lingua: $overrides['lingua'] ?? $faker->randomElement(LinguaGioco::cases()),
                imgProdotto: $immaginePredefinita,
                prezzo: $prezzo,
                giocoBase: $overrides['giocoBase'] ?? null,
                numeroGiocatoriMin: $giocatoriMin,
                numeroGiocatoriMax: $giocatoriMax,
                etaMinima: $etaMinima,
                durataMedia: $durataMedia,
            );

            if ($disponibilita === DisponibilitaProdotto::InArrivo) {
                $gioco->rendiInArrivo();
            } elseif ($disponibilita === DisponibilitaProdotto::NonDisponibile) {
                $gioco->rimuoviProdotto();
            }


            // sconto "manuale" indipendente dal danno, per testare il filtro "sconti"
            if (!empty($overrides['sconto'])) {
                $prezzo->aggiornaSconto($overrides['sconto']);
            }



            // numero vendite, per il filtro/ordinamento "popolarita"
            if (!empty($overrides['vendite'])) {
                $gioco->aggiungiVendite($overrides['vendite']);
            }

            // valutazione media, per "rating_min" e l'ordinamento "rating" (vedi Reflection sopra)
            if (isset($overrides['valutazione'])) {
                $this->setProtectedProperty($gioco, 'valutazioneMedia', $overrides['valutazione']);
            }

            // data di pubblicazione, per l'ordinamento di default e il filtro "novita"
            if (isset($overrides['dataPubblicazione'])) {
                $this->setProtectedProperty($gioco, 'dataPubblicazione', $overrides['dataPubblicazione']);
            }

            return $gioco;
        };

        // ---------------------------------------------------------------
        // 1) Giochi generati casualmente (dati di riempimento)
        // ---------------------------------------------------------------
        $giochi = [];
        for ($i = 0; $i < self::NUM_GIOCHI_RANDOM; $i++) {
            $gioco = $creaGioco([
                'vendite' => $faker->numberBetween(0, 300),
                'valutazione' => round($faker->randomFloat(1, 0, 5), 1),
                'dataPubblicazione' => $faker->dateTimeBetween('-2 years', '-2 months'),
            ]);

            $this->addReference('gioco_' . $i, $gioco);
            $manager->persist($gioco);
            $giochi[] = $gioco;
        }

        // danno su 3 giochi, uno per ogni livello (come nella fixture originale, ma con tutti i livelli)
        $mappaDanni = [
            0 => ['danno_1', 'Piccola piega sul tabellone'],
            1 => ['danno_2', 'Carta leggermente rovinata'],
            2 => ['danno_3', 'Scatola ammaccata'],
        ];
        foreach ($mappaDanni as $idx => [$rif, $descrizione]) {
            $danno = $this->getReference($rif, EDanno::class);
            $giochi[$idx]->aggiungiDanno($danno, $descrizione);
            $prezzo = $giochi[$idx]->getPrezzo();
            $prezzo->aggiornaValore($prezzo->getValore() - $prezzo->getValore() * $danno->getScontoDanno() / 100);
            $prezzo->aggiornaSconto($danno->getScontoDanno());
        }

        // ---------------------------------------------------------------
        // 2) Giochi deterministici per coprire i casi limite dei filtri
        // ---------------------------------------------------------------

        // fascia di prezzo ampia, per price_min
        $giochi[] = $creaGioco(['nome' => 'Gioco In Arrivo Test', 'disponibilita' => DisponibilitaProdotto::InArrivo]);
        $giochi[] = $creaGioco(['nome' => 'Gioco Non Disponibile Test', 'disponibilita' => DisponibilitaProdotto::NonDisponibile]);
        $giochi[] = $creaGioco(['nome' => 'Gioco Esaurito Test', 'disponibilita' => DisponibilitaProdotto::Esaurito]);

        $giochi[] = $creaGioco(['nome' => 'Gioco Economico Test', 'prezzo' => 2.50]);
        $giochi[] = $creaGioco(['nome' => 'Gioco Costoso Test', 'prezzo' => 59.90]);

        // numero giocatori: il filtro fa un'uguaglianza esatta, non un range
        $giochi[] = $creaGioco(['nome' => 'Solitario Test', 'giocatoriMin' => 1, 'giocatoriMax' => 1]);
        $giochi[] = $creaGioco(['nome' => 'Party Game Test', 'giocatoriMin' => 4, 'giocatoriMax' => 8]);

        // età minima esatta
        $giochi[] = $creaGioco(['nome' => 'Gioco Bambini Test', 'etaMinima' => 6]);
        $giochi[] = $creaGioco(['nome' => 'Gioco Adulti Test', 'etaMinima' => 18]);

        // pubblicato di recente, per il filtro "novita" (ultimo mese)
        $giochi[] = $creaGioco([
            'nome' => 'Novita Test',
            'dataPubblicazione' => $faker->dateTimeBetween('-10 days', 'now'),
            'vendite' => 5,
            'valutazione' => 4.5,
        ]);

        // sconto manuale senza danno, per il filtro "sconti"
        $giochi[] = $creaGioco(['nome' => 'Gioco In Sconto Test', 'prezzo' => 40.00, 'sconto' => 15]);

        // rating alto/basso, per rating_min e ordinamento "rating"/"popolarita"
        $giochi[] = $creaGioco(['nome' => 'Capolavoro Test', 'valutazione' => 5.0, 'vendite' => 500]);
        $giochi[] = $creaGioco(['nome' => 'Flop Test', 'valutazione' => 0.5, 'vendite' => 1]);

        // persistiamo e flushiamo tutto: servono ID reali PRIMA di creare le espansioni
        // (vedi nota sul bug di verificaVincoliEspansione())
        foreach ($giochi as $g) {
            if (!$manager->contains($g)) {
                $manager->persist($g);
            }
        }
        $manager->flush();

        // ---------------------------------------------------------------
        // 3) Espansioni, per il filtro "mostra_espansioni"
        // ---------------------------------------------------------------
        $giocoBase1 = $giochi[3]; // giochi random già persistiti, ora con id reale
        $giocoBase2 = $giochi[5];

        $espansione1 = $creaGioco(['nome' => 'Espansione Test 1', 'giocoBase' => $giocoBase1]);
        $espansione2 = $creaGioco(['nome' => 'Espansione Test 2', 'giocoBase' => $giocoBase2]);

        $manager->persist($espansione1);
        $manager->persist($espansione2);

        $this->addReference('gioco_espansione_1', $espansione1);
        $this->addReference('gioco_espansione_2', $espansione2);

        $manager->flush();
    }
}