<?php
// Controleer of autoload.php correct wordt geladen
$autoloadPath = __DIR__ . '/../vendor/autoload.php';

if (file_exists($autoloadPath)) {
    echo "Autoload file gevonden op: $autoloadPath";
    require $autoloadPath;
} else {
    echo "Autoload file NIET gevonden op: $autoloadPath";
    exit; // Stop het script als autoload.php niet wordt gevonden
}

use Cloudinary\Configuration\Configuration;

Configuration::instance([
    'cloud' => [
        'cloud_name' => 'di1c3petu',
        'api_key'    => '795931936958539',
        'api_secret' => 'nkAVSDYQlvEX3bQMNCzHfTDf46c',
    ],
]);
?>
