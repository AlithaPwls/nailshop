<?php
session_start();

if ($_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

include_once 'classes/products.php';

$conn = new mysqli('localhost', 'root', '', 'shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];
$userStatement = $conn->prepare('SELECT * FROM users WHERE email = ?');
$userStatement->bind_param('s', $email);
$userStatement->execute();
$userResult = $userStatement->get_result();
$user = $userResult->fetch_assoc(); // Verkrijg de gebruiker


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Valideer de invoer
        $colorName = htmlspecialchars($_POST['color_name'], ENT_QUOTES, 'UTF-8');
        $colorNumber = htmlspecialchars($_POST['color_number'], ENT_QUOTES, 'UTF-8');
        $price = floatval($_POST['price']); // Zorg dat dit een geldig getal is
        $hasGlitter = isset($_POST['has_glitter']) ? 1 : 0;
        $imageUrl = htmlspecialchars($_POST['image_url'], ENT_QUOTES, 'UTF-8');
        $colorGroup = htmlspecialchars($_POST['color_group'], ENT_QUOTES, 'UTF-8');
        $colorDescription = htmlspecialchars($_POST['color_description'], ENT_QUOTES, 'UTF-8'); // hier wast fout

        // Opslaan in de database
        $product = new Product();
        $product->setColorName($colorName);
        $product->setColorNumber($colorNumber);
        $product->setPrice($price);
        $product->setHasGlitter($hasGlitter);
        $product->setImageUrl($imageUrl);
        $product->setColorGroup($colorGroup);
        $product->setColorDescription($colorDescription);
        $product->save();

        echo "Product succesvol toegevoegd!";
    } catch (Exception $e) {
        echo "Fout: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
}
?><!DOCTYPE html>
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
    <form action="add_product.php" method="post" class="foremeke">
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
            <input type="checkbox" id="has_glitter" name="has_glitter" value = "1">
        </div>

        <div class="field">
            <label for="image_url">Image-URL:</label>
            <input type="text" id="image_url" name="image_url" required>
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