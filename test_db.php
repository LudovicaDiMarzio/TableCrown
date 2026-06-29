<?php
// 1. Includi il file di "loading" di Doctrine (quello che crea l'$entityManager)
// Sostituisci 'bootstrap.php' con il nome reale del file che usate per inizializzare Doctrine
require_once "bootstrap.php"; 
// Accende il "navigatore" per trovare le classi
require_once __DIR__ . '/vendor/autoload.php'; 
// (In alternativa puoi usare: require_once 'bootstrap.php'; se si trova nella stessa cartella)

// 2. Includi le classi che ti servono (se non avete un autoloader automatico)

use TableCrown\Foundation\FPersistentManager;
use TableCrown\Entity\EUtente;
use TableCrown\Entity\Enumerativi\PlayerLevel;

// --- TEST 1: Verifica Esistenza ---
$emailTest = "test@email.it";
$pm =FPersistentManager::getPersistentManager();
$esiste = $pm->PMverificaEsistenza(EUtente::class, 'emailpersona', $emailTest);

var_dump($esiste);
if ($esiste) {
    echo "L'email $emailTest esiste già nel DB!<br>";
} else {
    var_dump($esiste);
    echo "L'email $emailTest è libera. Procedo a salvare...<br>";
    
    // --- TEST 2: Salvataggio (SaveObj) ---
    $nuovoUtente = new EUtente("Mario Rossi", $emailTest, 'pswuser12345678', '23', PlayerLevel::PRINCIPIANTE);
    $salvato = $pm->PMsaveObj($nuovoUtente);
    
    if ($salvato) {
        echo "✅ Utente salvato con successo!<br>";
    } else {
        echo "❌ Errore durante il salvataggio.<br>";
    }
}