<?php
namespace Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

// Importiamo la classe dal tuo progetto
use TableCrown\Entity\EAmministratore;

class AmministratoreFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        echo "Generazione dell'Amministratore unico in corso...\n";

        // Creiamo 1 solo amministratore con dati fissi e facili da ricordare
        $admin = new EAmministratore(
            "Admin TableCrown",                            // nome
            "admin@tablecrown.it",                         // email (usala per il login!)
            password_hash("Admin#123", PASSWORD_BCRYPT),   // password
            "assets/images/admin_avatar.png"               // img
        );

        // Mettiamo il segnalibro nel caso servisse in futuro
        $this->addReference('admin_unico', $admin);

        $manager->persist($admin);
        $manager->flush();
        
        echo "Amministratore creato con successo (Email: admin@tablecrown.it)!\n";
    }
}