<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

// Importiamo la classe dal tuo progetto
use TableCrown\Entity\EGestore;

class GestoreFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        echo "Generazione del Gestore unico in corso...\n";

        // Creiamo 1 solo gestore con dati fissi
        $gestore = new EGestore(
            "Gestore TableCrown",                            // nome
            "gestore@tablecrown.it",                         // email (usala per il login!)
            password_hash("Gestore#123", PASSWORD_BCRYPT),   // password
            "assets/images/gestore_avatar.png"               // img
        );

        // Mettiamo il segnalibro
        $this->addReference('gestore_unico', $gestore);

        $manager->persist($gestore);
        $manager->flush();
        
        echo "Gestore creato con successo (Email: gestore@tablecrown.it)!\n";
    }
}