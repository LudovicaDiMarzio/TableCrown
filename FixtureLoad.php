<?php
require_once 'bootstrap.php';

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use TableCrown\Testing\Fixtures\UtenteFixture;
use TableCrown\Testing\Fixtures\MotivazioneFixture;
use TableCrown\Testing\Fixtures\AmministratoreFixture;
use TableCrown\Testing\Fixtures\GestoreFixture;
use TableCrown\Testing\Fixtures\BustineFixture;
use TableCrown\Testing\Fixtures\PortaDadiFixture;
use TableCrown\Testing\Fixtures\GiocoDaTavoloFixture;
use TableCrown\Testing\Fixtures\DannoFixture;
use TableCrown\Testing\Fixtures\RecensioneFixture;
use TableCrown\Testing\Fixtures\SegnalazioneFixture;
use TableCrown\Testing\Fixtures\ProvvedimentoFixture;
use TableCrown\Testing\Fixtures\CartaDiCreditoFixture;
use TableCrown\Testing\Fixtures\IndirizzoFixture;
use TableCrown\Testing\Fixtures\OrdineFixture;
use TableCrown\Testing\Fixtures\WishlistFixture;
use TableCrown\Testing\Fixtures\EventoFixture;


//creo l'entity manager
$em = getEntityManagerBoot();

//cerca i file che estendono AbstractFixture li organizza nell'ordine corretto 
$loader = new Loader();



// aggiungi le fixture nell'ordine corretto
$loader->addFixture(new UtenteFixture());
$loader->addFixture(new MotivazioneFixture());
$loader->addFixture(new AmministratoreFixture());
$loader->addFixture(new GestoreFixture());
$loader->addFixture(new BustineFixture());
$loader->addFixture(new PortaDadiFixture());
$loader->addFixture(new GiocoDaTavoloFixture());
$loader->addFixture(new DannoFixture()); 
$loader->addFixture(new RecensioneFixture());
$loader->addFixture(new SegnalazioneFixture());
$loader->addFixture(new ProvvedimentoFixture());
$loader->addFixture(new CartaDiCreditoFixture());
$loader->addFixture(new IndirizzoFixture());
$loader->addFixture(new OrdineFixture());
$loader->addFixture(new WishlistFixture());
$loader->addFixture(new EventoFixture());



$purger = new ORMPurger($em);  // svuota il db prima di inserire
//crea l'istanza di doctrine ormexecutor che svuota le tabelle (con il purger) e inserisce i dati di test con l'entity manager
$executor = new ORMExecutor($em, $purger);

//avvia concretamente il processo di svuotamento e inserimento dei dati, con il loader che recupera le classi fixture e le dispone in un array pronto per l'esecuzione
$executor->execute($loader->getFixtures());

// 1. Diciamo al DB di ignorare temporaneamente i vincoli di integrità
$em->getConnection()->executeStatement('SET FOREIGN_KEY_CHECKS=0');

// 3. Riattiviamo immediatamente i controlli per la sicurezza del DB
$em->getConnection()->executeStatement('SET FOREIGN_KEY_CHECKS=1');

echo "Fixture caricate con successo!\n";