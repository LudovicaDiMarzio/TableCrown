<?php
// Diamo un namespace coerente con la cartella in cui ci troviamo
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

// Importiamo la classe utente
use TableCrown\Entity\EUtente;
use TableCrown\Entity\Enumerativi\PlayerLevel;

class UtenteFixture extends AbstractFixture
{
    // Quanti utenti vogliamo generare?
    private const NUM_UTENTI = 10;

    public function load(ObjectManager $manager): void
    {
        // Inizializziamo Faker per avere nomi e dati in italiano
        $faker = Factory::create('it_IT');

        // Estraiamo tutti i livelli possibili dall'Enum PlayerLevel
        $livelliDisponibili = PlayerLevel::cases();

        echo "Generazione di " . self::NUM_UTENTI . " utenti in corso...\n";

        for ($i = 0; $i < self::NUM_UTENTI; $i++) {
            
            // Peschiamo un livello a caso tra quelli disponibili nell'Enum
            $livelloCasuale = $livelliDisponibili[array_rand($livelliDisponibili)];

            // Creiamo l'utente rispettando il costruttore
            $utente = new EUtente(
                $faker->userName(),                              // nomeuser
                "assets/images/default_avatar.png",              // imgprofilouser
                $faker->unique()->safeEmail(),                   // emailuser
                password_hash("Password#123", PASSWORD_BCRYPT),  // passworduser criptata
                $faker->numberBetween(18, 90),                   // eta (tra 18 e 90 anni)
                $livelloCasuale                                  // PlayerLevel (Enum)
            );

            // Salviamo un "segnalibro" per questo utente. 
            // Ci tornerà utilissimo quando creeremo la Fixture degli Ordini!
            $this->addReference('utente_' . $i, $utente);

            // Diciamo a Doctrine di preparare questo utente
            $manager->persist($utente);
        }

        // Salviamo tutti i 20 utenti nel database in un colpo solo
        $manager->flush();
        
        echo "Utenti creati e salvati con successo!\n";
    }
}