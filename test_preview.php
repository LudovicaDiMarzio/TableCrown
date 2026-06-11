<?php
$basePath = __DIR__;

echo "<h2>🕵️ Spione delle Cartelle Attivo</h2>";
echo "La root del progetto è: <code>" . htmlspecialchars($basePath) . "</code><br><br>";

if (is_dir($basePath)) {
    echo "<strong>Contenuto della cartella TableCrown:</strong><br><ul>";
    $files = scandir($basePath);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $fullPath = $basePath . '/' . $file;
            $type = is_dir($fullPath) ? '📁 CARTELLA' : '📄 FILE';
            echo "<li><strong>[$type]</strong> $file";
            
            // Se trova qualcosa che somiglia a presentation, guarda dentro
            if (is_dir($fullPath) && strtolower($file) === 'presentation') {
                echo "<ul>";
                $subFiles = scandir($fullPath);
                foreach ($subFiles as $subFile) {
                    if ($subFile !== '.' && $subFile !== '..') {
                        $subType = is_dir($fullPath . '/' . $subFile) ? '📁 CARTELLA' : '📄 FILE';
                        echo "<li><strong>[$subType]</strong> $subFile</li>";
                    }
                }
                echo "</ul>";
            }
            
            echo "</li>";
        }
    }
    echo "</ul>";
} else {
    echo "La cartella principale non esiste.";
}