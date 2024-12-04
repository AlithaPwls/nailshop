<?php
session_start();

if ($_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

include_once (__DIR__ . "/classes/Products.php");
include_once (__DIR__ . "/classes/User.php"); 

$email = $_SESSION['email'];
$user = User::getUserByEmail($email); 

include_once("classes/Db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $colorName = htmlspecialchars($_POST['color_name'], ENT_QUOTES, 'UTF-8');
        $colorNumber = htmlspecialchars($_POST['color_number'], ENT_QUOTES, 'UTF-8');
        $price = floatval($_POST['price']); // dit getal moet geldig zijn dus niet negatief
        $hasGlitter = isset($_POST['has_glitter']) ? 1 : 0;
        $colorGroup = htmlspecialchars($_POST['color_group'], ENT_QUOTES, 'UTF-8');
        $colorDescription = htmlspecialchars($_POST['color_description'], ENT_QUOTES, 'UTF-8');

        // Bestand uploaden
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            // Upload directory instellen
            $uploadDir = __DIR__ . '/uploads/'; // Zorg dat dit de juiste map is

            // Bestand ophalen en controleren
            $uploadedFile = $_FILES['image_file'];
            $fileExtension = strtolower(pathinfo($uploadedFile['name'], PATHINFO_EXTENSION));
            
            // Controleer of bestandstype is toegestaan
            $allowedExtensions = ['jpeg', 'jpg', 'png', 'webp'];
            if (!in_array($fileExtension, $allowedExtensions)) {
                throw new Exception("Alleen JPEG, PNG, en WEBP-bestanden zijn toegestaan.");
            }

            // Genereer een unieke naam voor het bestand
            $fileName = uniqid('product_', true) . '.' . $fileExtension;
            $filePath = $uploadDir . $fileName;

            // Verplaats het bestand naar de uploads-map
            if (!move_uploaded_file($uploadedFile['tmp_name'], $filePath)) {
                throw new Exception("Uploaden van afbeelding mislukt.");
            }

            // Zet het relatieve pad voor opslag in de database
            $imageUrl = 'uploads/' . $fileName;
        } else {
            throw new Exception("Geen afbeelding geüpload of er is een uploadfout.");
        }

        // Nieuw product maken en opslaan
        $product = new Products();
        $product->setColorName($colorName);
        $product->setColorNumber($colorNumber);
        $product->setPrice($price);
        $product->setHasGlitter($hasGlitter);
        $product->setImageUrl($imageUrl); // Gebruik het geüploade bestandspad
        $product->setColorGroup($colorGroup);
        $product->setColorDescription($colorDescription);
        $product->save();

        echo "Product succesvol toegevoegd! 🩷";
    } catch (Exception $e) {
        echo "Fout: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
}
?>
