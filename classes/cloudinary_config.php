<?php
require '../vendor/autoload.php'; // Zorg dat dit pad klopt

use Cloudinary\Configuration\Configuration;

Configuration::instance([
    'cloud' => [
        'cloud_name' => 'nailshop',
        'api_key'    => '795931936958539',
        'api_secret' => 'nkAVSDYQlvEX3bQMNCzHfTDf46c',
    ],
]);
?>
