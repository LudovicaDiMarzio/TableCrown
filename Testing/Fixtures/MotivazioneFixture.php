<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

// Importiamo le classi dal tuo progetto
use TableCrown\Entity\EMotivazione;
use TableCrown\Entity\Enumerativi\GravitaMotivazione;

//non usiamo il faker per creare le motivazioni, perché non vogliamo che siano random quelle di default
class MotivazioneFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        // Creiamo un array con le motivazioni di default (come hai scritto nei commenti) 
        // e ne aggiungiamo qualcuna extra per testare bene il sistema
        $motivazioniPredefinite = [
            ['nome' => 'Contenuto inappropriato', 'gravita' => GravitaMotivazione::ALTA],
            ['nome' => 'Spam o pubblicità non richiesta', 'gravita' => GravitaMotivazione::MEDIA],
            ['nome' => 'Linguaggio offensivo o minacce', 'gravita' => GravitaMotivazione::ALTA],
            ['nome' => 'Truffa o comportamento scorretto', 'gravita' => GravitaMotivazione::ALTA],
            ['nome' => 'Altro', 'gravita' => GravitaMotivazione::BASSA],
        ];

        echo "Generazione delle " . count($motivazioniPredefinite) . " motivazioni di default in corso...\n";

        foreach ($motivazioniPredefinite as $indice => $dati) {
            
            // Creiamo la motivazione passandogli la stringa e l'Enum corretto
            $motivazione = new EMotivazione($dati['nome'], $dati['gravita']);

            // Salviamo il segnalibro! 
            // Ti sarà utilissimo quando creeremo la Fixture delle Segnalazioni.
            // Es: $this->getReference('motivazione_0') prenderà "Contenuto inappropriato"
            $this->addReference('motivazione_' . $indice, $motivazione);

            // Prepariamo per il salvataggio
            $manager->persist($motivazione);
        }

        // Salviamo tutto nel database
        $manager->flush();
        
        echo "Motivazioni create e salvate con successo!\n";
    }
}