<?php
namespace TableCrown\Testing\Fixtures;
 
//estendo la classe abstract fixture per poter usare i metodi di doctrine addReference e getReference per gestire i riferimenti tra classi
use Doctrine\Common\DataFixtures\AbstractFixture;

//estendo la classe object manager per poter usare i metodi di doctrine persist, flush ecc ecc (permette di gestire il ciclo di vita delle entità)
use Doctrine\Persistence\ObjectManager;

//libreria esterna per generare i dati random
use Faker\Factory;

//per creare relazioni tra entità è necessario implementare l'interfaccia dependent fixture
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

//importo le classi Entity e gli enum necessari
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
    // metodo obbligatorio che dice quali fixture devono essere caricate prima
    public function getDependencies(): array
    {
        return [DannoFixture::class];
    }

    private const NUM_GIOCHI = 10;

    //metodo doctrine che viene eseguito da FixtureLoad.php per creare le entità e salvarle nel database
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT'); //creazione istanza di faker per la lingua italiana

        


        $componentiDisponibili = [
            'Tabellone', 'Carte', 'Pedine', 'Dadi', 
            'Segnalini', 'Token', 'Plance giocatore'
        ];

        

        for ($i = 0; $i < self::NUM_GIOCHI; $i++) { //self::NUM_GIOCHI serve per leggere la costante
            
            // peschiamo 1-3 categorie casuali
            $categorieEnum = $faker->randomElements(
                Categoria::cases(),
                $faker->numberBetween(1, 3)
            );

            // Estraiamo solo il testo (es. "strategia", "avventura")
            $categorieTesto = array_map(fn($cat) => $cat->value, $categorieEnum);
            
            // peschiamo 2-5 componenti casuali
            $componenti = $faker->randomElements(
                $componentiDisponibili,
                $faker->numberBetween(2, 5)
            );

            // Creiamo un prezzo casuale (sfruttando il Cascade Persist di cui parlavamo!)
            $prezzo = new EPrezzo($faker->randomFloat(2, 2, 15), Valuta::EUR);


            // 2. Peschiamo un valore a caso dall'Enum della disponibilità
            $disponibilita = $faker->randomElement(DisponibilitaProdotto::cases());

            if ($disponibilita === DisponibilitaProdotto::Esaurito || $disponibilita === DisponibilitaProdotto::NonDisponibile || $disponibilita === DisponibilitaProdotto::InArrivo) {
                $quantitaCorerente = 0;
            } else {
                $quantitaCorerente = $faker->numberBetween(10, 100);
            }

            //chiamo il costruttore di EBustine con i dati random
            $gioco= new EGiocoDaTavolo(
                $faker->words(3, true),           // nomeProdotto
                $faker->paragraph(),              // descrizioneProdotto
                $disponibilita,                   // disponibilitaProdotto
                $quantitaCorerente,   // quantita
                categoria: $categorieTesto, //categoria
                componenti: $componenti, //componenti
                prezzo: $prezzo,                     // prezzo
                lingua: $faker->randomElement(LinguaGioco::cases()),
                difficolta: $faker->randomElement(DifficoltaGioco::cases()),
                );

                

                
                // per gli ultimi 2 giochi aggiungi un danno
                if ($i === 8) {
                    $danno = $this->getReference('danno_1', EDanno::class);
                    $gioco->aggiungiDanno($danno, 'Piccola piega sul tabellone');
                    $prezzoscontato=$prezzo->getValore()-$prezzo->getValore()*$danno->getScontoDanno()/100;
                    $prezzo->aggiornaValore($prezzoscontato);
                    $prezzo->aggiornaSconto($danno->getScontoDanno()); //aggiungiamo uno sconto del 10% per il danno
                } elseif ($i === 9) {
                    $danno = $this->getReference('danno_2', EDanno::class);
                    $gioco->aggiungiDanno($danno, 'Carta leggermente rovinata');
                    $prezzoscontato=$prezzo->getValore()-$prezzo->getValore()*$danno->getScontoDanno()/100;
                    $prezzo->aggiornaValore($prezzoscontato);
                    $prezzo->aggiornaSconto($danno->getScontoDanno());
                }

                // salva riferimento per usarlo in altre fixture
                $this->addReference('gioco_' . $i, $gioco);
                //salva la traccia dell'entità nel IdentityMap e nella UnitOfWork
                $manager->persist($gioco);


        }


        //esegue le query appese nella UnitOfWork
        $manager->flush();
    }
}
