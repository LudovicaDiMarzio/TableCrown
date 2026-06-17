<?php
namespace TableCrown\Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use TableCrown\Entity\EGestore;

class GestoreFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        //creo un gestore di default

        $gestore= new EGestore(
            nome: 'gestoreuser',
            email:'gestore@gmail.com',
            password:'gestorepsw'
        );
        

        //salvo il riferimento per usarlo in altre fixture
        $this->addReference('gestore', $gestore);
        //creo l'entità nell'IdentityMap e nella UnitOfWork
        $manager->persist($gestore);
        

        //eseguo le query nella UnitOfWork
        $manager->flush();
    }
}