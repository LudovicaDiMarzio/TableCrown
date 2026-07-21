<?php
namespace TableCrown\Testing\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use TableCrown\Entity\EMotivazione;
use TableCrown\Entity\Enumerativi\GravitaMotivazione;

class MotivazioneFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        //creo un array con tutte le motivazioni di default
        $motivazioni = [
            ['nome' => 'Spam',                  'gravita' => GravitaMotivazione::BASSA],
            ['nome' => 'Contenuto offensivo',   'gravita' => GravitaMotivazione::ALTA],
            ['nome' => 'Contenuto inappropriato','gravita' => GravitaMotivazione::MEDIA],
            ['nome' => 'Altro',                  'gravita' => GravitaMotivazione::BASSA],
        ];

        //creo un oggetto motivazione per ogni motivazionenell'array
        foreach ($motivazioni as $i => $dati) {
            $motivazione = new EMotivazione(
                $dati['nome'],
                $dati['gravita']
            );

            //salvo il riferimento per usarlo in altre fixture
            $this->addReference('motivazione_' . $i, $motivazione);
            //creo l'entità nell'IdentityMap e nella UnitOfWork
            $manager->persist($motivazione);
        }

        //eseguo le query nella UnitOfWork
        $manager->flush();
    }
}