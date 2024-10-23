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
    <link rel="stylesheet" href="css/addproduct.css">
    <title>Voeg Product Toe</title>
</head>
<body>
    <h1>Add new product</h1>
    <form action="add_product.php" method="post">
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
            <input type="text" id="color_group" name="color_group" required>
        </div>

        <button class="btn" type="submit">Add product to website</button>
    </form>
</body>
</html>
