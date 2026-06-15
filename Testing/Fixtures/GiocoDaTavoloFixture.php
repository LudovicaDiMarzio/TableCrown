<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

// Importiamo le classi dal tuo progetto
use TableCrown\Entity\EGiocoDaTavolo;
use TableCrown\Entity\EPrezzo;
use TableCrown\Entity\Enumerativi\DisponibilitaProdotto;
use TableCrown\Entity\Enumerativi\Valuta;
use TableCrown\Entity\Enumerativi\Categoria;

class GiocoDaTavoloFixture extends AbstractFixture
{
    private const NUM_GIOCHI = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');

        // Prendiamo in automatico tutte le categorie che hai definito nell'Enum
        $categorieDisponibili = Categoria::cases();
        
        // Un array finto da cui pescare i componenti
        $componentiPossibili = ["Tabellone", "Dadi", "Carte", "Pedine in legno", "Segnalini", "Regolamento", "Clessidra"];

        echo "Generazione di " . self::NUM_GIOCHI . " giochi da tavolo in corso...\n";

        for ($i = 0; $i < self::NUM_GIOCHI; $i++) {
            
            // 1. Creiamo il Prezzo al volo (Doctrine lo salverà in automatico grazie al cascade!)
            $prezzoFinto = new EPrezzo(
                $faker->randomFloat(2, 19, 89),               // Valore casuale tra 19.xx e 89.xx
                Valuta::EUR,                                  // Valuta fissa a EUR
                $faker->randomElement([0, 0, 0, 10, 20])      // Simuliamo che solo alcuni giochi siano in sconto
            );

            // 2. Peschiamo un numero casuale di categorie e componenti
            $categorieGioco = $faker->randomElements($categorieDisponibili, $faker->numberBetween(1, 3));
            $componentiGioco = $faker->randomElements($componentiPossibili, $faker->numberBetween(2, 5));

            // 3. Creiamo il gioco da tavolo rispettando i tuoi vincoli di dominio
            $gioco = new EGiocoDaTavolo(
                "Gioco " . ucfirst($faker->word()) . " " . ucfirst($faker->word()), // nomeProdotto
                $faker->paragraph(),                                  // descrizioneProdotto
                DisponibilitaProdotto::Disponibile,                   // disponibilitaProdotto
                $faker->numberBetween(5, 50),                         // quantita (tra 5 e 50 in magazzino)
                $categorieGioco,                                      // categoria (array)
                $componentiGioco,                                     // componenti (array)
                "assets/images/default_game.png",                     // imgProdotto
                $prezzoFinto,                                         // prezzo 
                null,                                                 // giocoBase (nessuna espansione per ora)
                $faker->numberBetween(1, 2),                          // numeroGiocatoriMin
                $faker->numberBetween(4, 8),                          // numeroGiocatoriMax
                $faker->numberBetween(8, 14),                         // etaMinima
                $faker->numberBetween(30, 120)                        // durataMedia (in minuti)
                // EDanno e descrizioneDanno li omettiamo (saranno null per default)
            );

            // 4. Salviamo il SEGNALIBRO! Così potremo agganciare questo gioco agli ordini o alle recensioni
            $this->addReference('gioco_' . $i, $gioco);

            $manager->persist($gioco);
        }

        $manager->flush();
        
        echo "Giochi da tavolo creati e salvati con successo!\n";
    }
}