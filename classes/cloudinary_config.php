<?php
echo __DIR__;

require __DIR__ . '/../vendor/autoload.php';

// Test of de Uploader-klasse bestaat
use Cloudinary\Uploader;

if (class_exists('Cloudinary\Uploader')) {
    echo "Cloudinary Uploader class is loaded!";
} else {
    echo "Cloudinary Uploader class is NOT loaded.";
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
