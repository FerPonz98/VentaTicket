<?php

// Mostrar errores en pantalla
ini_set('display_errors', 1);
error_reporting(E_ALL);

function deleteFolderFiles($folderPath) {
    if (!is_dir($folderPath)) return;
    foreach (glob($folderPath . '/*') as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
}

$base = dirname(__DIR__); // Ajusta si lo ubicas en otro lado
$bootstrapCache = $base . '/bootstrap/cache';
$viewCache = $base . '/storage/framework/views';

$configFile = $bootstrapCache . '/config.php';
$packagesFile = $bootstrapCache . '/packages.php';

$msgs = [];

// Eliminar config.php
if (file_exists($configFile)) {
    unlink($configFile);
    $msgs[] = "✅ config.php eliminado.";
} else {
    $msgs[] = "ℹ️ config.php no encontrado.";
}

// Eliminar packages.php
if (file_exists($packagesFile)) {
    unlink($packagesFile);
    $msgs[] = "✅ packages.php eliminado.";
} else {
    $msgs[] = "ℹ️ packages.php no encontrado.";
}

// Eliminar archivos cacheados de vistas (excepto .gitignore)
if (is_dir($viewCache)) {
    $count = 0;
    foreach (glob($viewCache . '/*') as $file) {
        if (basename($file) !== '.gitignore') {
            unlink($file);
            $count++;
        }
    }
    $msgs[] = "✅ $count archivos de vistas eliminados.";
} else {
    $msgs[] = "❌ Carpeta de vistas no encontrada.";
}

// Resultado
echo "<h2 style='color:green;'>✔ Caché de Laravel limpiada correctamente.</h2>";
echo "<ul>";
foreach ($msgs as $m) echo "<li>$m</li>";
echo "</ul>";
