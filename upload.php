<?php
require 'vendor/autoload.php';

use Cloudinary\Cloudinary;

$cloudinary = new Cloudinary([
    'cloud' => [
        'cloud_name' => 'nailshop',
        'api_key'    => '795931936958539',
        'api_secret' => 'nkAVSDYQlvEX3bQMNCzHfTDf46c',
    ],
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image']['tmp_name'];
    $response = $cloudinary->uploadApi()->upload($file);
    echo "Afbeelding geüpload! URL: " . $response['secure_url'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload naar Cloudinary</title>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Upload Afbeelding</button>
    </form>
</body>
</html>
