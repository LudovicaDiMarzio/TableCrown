<?php
namespace TableCrown\Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

// Importiamo le Entity e l'Enum
use TableCrown\Entity\EDanno;
use TableCrown\Entity\Enumerativi\LivelloDannoGiochi;

class DannoFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $dannolieve = new EDanno(LivelloDannoGiochi::L1);
        $dannomedio = new EDanno(LivelloDannoGiochi::L2);
        $dannoalto = new EDanno(LivelloDannoGiochi::L3);

        $this->addReference('danno_1', $dannolieve);
        $this->addReference('danno_2', $dannomedio);
        $this->addReference('danno_3', $dannoalto);

        $manager->persist($dannolieve);
        $manager->persist($dannomedio);
        $manager->persist($dannoalto);

        $manager->flush();
    }
}