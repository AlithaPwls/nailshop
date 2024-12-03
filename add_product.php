<?php
session_start();

if ($_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

include_once (__DIR__ . "/classes/Products.php");
include_once (__DIR__ . "/classes/User.php"); // Zorg ervoor dat de juiste klasse wordt geladen

$email = $_SESSION['email'];
$user = User::getUserByEmail($email); // Haal de gebruiker op via de juiste methode van de User-klasse

include_once("classes/Db.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Valideer de invoer
        $colorName = htmlspecialchars($_POST['color_name'], ENT_QUOTES, 'UTF-8');
        $colorNumber = htmlspecialchars($_POST['color_number'], ENT_QUOTES, 'UTF-8');
        $price = floatval($_POST['price']); // Zorg dat dit een geldig getal is
        $hasGlitter = isset($_POST['has_glitter']) ? 1 : 0;
        $colorGroup = htmlspecialchars($_POST['color_group'], ENT_QUOTES, 'UTF-8');
        $colorDescription = htmlspecialchars($_POST['color_description'], ENT_QUOTES, 'UTF-8');

        // Bestand uploaden
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/nailshop/images/';
            $uploadedFile = $_FILES['image_file'];
            $fileExtension = strtolower(pathinfo($uploadedFile['name'], PATHINFO_EXTENSION));
            
            // Controleer bestandstype
            $allowedExtensions = ['jpeg', 'jpg', 'png'];
            if (!in_array($fileExtension, $allowedExtensions)) {
                throw new Exception("Only JPEG and PNG files are allowed.");
            }

            // Genereer een unieke naam voor de afbeelding
            $fileName = uniqid('product_', true) . '.' . $fileExtension;
            $filePath = $uploadDir . $fileName;


            
            if (!file_exists($uploadDir)) {
                throw new Exception("Upload directory does not exist: " . $uploadDir);
            }
            
            if (!is_writable($uploadDir)) {
                throw new Exception("Upload directory is not writable: " . $uploadDir);
            }

            
            if (!move_uploaded_file($uploadedFile['tmp_name'], $filePath)) {
                throw new Exception("Failed to upload image.");
            }

            // Zet het relatieve pad voor opslag in de database
            $imageUrl = 'images/' . $fileName;
        } else {
            throw new Exception("No image uploaded or upload error.");
        }

        // Maak een nieuw Product-object en sla het op
        $product = new Product();
        $product->setColorName($colorName);
        $product->setColorNumber($colorNumber);
        $product->setPrice($price);
        $product->setHasGlitter($hasGlitter);
        $product->setImageUrl($imageUrl); // Gebruik het geüploade bestandspad
        $product->setColorGroup($colorGroup);
        $product->setColorDescription($colorDescription);
        $product->save();

        echo "Product succesvol toegevoegd!";
    } catch (Exception $e) {
        echo "Fout: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/addproduct.css">
    <title>Voeg Product Toe</title>
</head>
<body>
    <?php include_once('nav.inc.php'); ?>
    <h1>Add new product</h1>
    <form action="add_product.php" method="post" class="foremeke" enctype="multipart/form-data">
    <div class="field">
        <label for="color_name">Color name:</label>
        <input type="text" id="color_name" name="color_name" required>
    </div>

    <div class="field">
        <label for="color_number">Color number:</label>
        <input type="text" id="color_number" name="color_number" required>
    </div>

    <div class="field">
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>
    </div>

    <div class="field">
        <label for="has_glitter">Has glitter:</label>
        <input type="checkbox" id="has_glitter" name="has_glitter" value="1">
    </div>

    <div class="field">
        <label for="image_url">Upload Image:</label>
        <input type="file" id="image_url" name="image_file" accept="image/*" required>
    </div>

    <div class="field">
        <label for="color_group">Color group:</label>
        <select id="color_group" name="color_group" required>
            <option value="" disabled selected>Kies een kleur groep</option>
            <option value="pink">Pink</option>
            <option value="red">Red</option>
            <option value="green">Green</option>
            <option value="blue">Blue</option>
            <option value="brown">Brown</option>
        </select>
    </div>

    <div class="field">
        <label for="color_description">Description</label>
        <input type="text" id="color_description" name="color_description" required>
    </div>

    <button class="btn" type="submit">Add product to website</button>
</form>

</body>
</html>
