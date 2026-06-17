<?php
namespace TableCrown\Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use TableCrown\Entity\EAmministratore;

class AmministratoreFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        //creo un admin di default

        $amministratore= new EAmministratore(
            nome: 'adminuser',
            email:'admin@gmail.com',
            password:'adminpsw'
        );
        

        //salvo il riferimento per usarlo in altre fixture
        $this->addReference('admin', $amministratore);
        //creo l'entità nell'IdentityMap e nella UnitOfWork
        $manager->persist($amministratore);
        

        //eseguo le query nella UnitOfWork
        $manager->flush();
    }
}