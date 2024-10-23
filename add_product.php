<?php
include_once(__DIR__ . "/classes/products.php");
session_start();

// Controleer of de gebruiker is ingelogd
if ($_SESSION['loggedin'] !== true) {
    header('Location: login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $product = new Product();
        $product->setColorName($_POST['color_name']);
        $product->setColorNumber($_POST['color_number']);
        $product->setPrice($_POST['price']);
        $product->setHasGlitter(isset($_POST['has_glitter']) ? 1 : 0);
        $product->setImageUrl($_POST['image_url']);
        $product->setColorGroup($_POST['color_group']);
        $product->save();

        echo "Product succesvol toegevoegd!";
    } catch (Exception $e) {
        echo "Fout: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Voeg Product Toe</title>
</head>
<body>
    <h1>Voeg een nieuw product toe</h1>
    <form action="add_product.php" method="post">
        <label for="color_name">Kleur Naam:</label>
        <input type="text" id="color_name" name="color_name" required>

        <label for="color_number">Kleur Nummer:</label>
        <input type="text" id="color_number" name="color_number" required>

        <label for="price">Prijs:</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <label for="has_glitter">Heeft Glitter:</label>
        <input type="checkbox" id="has_glitter" name="has_glitter">

        <label for="image_url">Afbeeldings-URL:</label>
        <input type="text" id="image_url" name="image_url" required>

        <label for="color_group">Kleur Groep:</label>
        <input type="text" id="color_group" name="color_group" required>

        <button type="submit">Voeg Product Toe</button>
    </form>
</body>
</html>
