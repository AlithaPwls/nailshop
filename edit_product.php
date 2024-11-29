<?php
// Zorg ervoor dat de Product-klasse geladen wordt


include_once (__DIR__ . "/classes/Products.php");



// De rest van je code blijft hetzelfde
session_start();
if ($_SESSION['loggedin'] !== true || (int)$_SESSION['is_admin'] !== 1) {
    header('Location: login.php');
    exit();
}

$product_id = $_GET['id'] ?? null;
$product = [
    'id' => '',
    'color_name' => '',
    'color_number' => '',
    'price' => '',
    'has_glitter' => 0,
    'image_url' => '',
    'color_group' => '',
    'description' => '',
];

if ($product_id) {
    // Haal productdata op uit de database via de Product::getById() methode
    $product = Product::getById($product_id) ?: $product;
}


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/addproduct.css">
    <title>Edit Product</title>
</head>
<body>
    <?php include_once('nav.inc.php'); ?>
    <h1>Edit Product</h1>

    <!-- Form om product te bewerken -->
    <form action="edit_product.php" method="POST" class="foremeke">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>"> <!-- Verberg de ID in het formulier -->
        
        <div class="field">
            <label for="color_name">Color Name</label>
            <input type="text" name="color_name" value="<?php echo htmlspecialchars($product['color_name']); ?>" required><br>
        </div>

        <div class="field">
            <label for="color_number">Color Number</label>
            <input type="text" name="color_number" value="<?php echo htmlspecialchars($product['color_number']); ?>" required><br>
        </div>

        <div class="field">
            <label for="price">Price</label>
            <input type="text" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br>
        </div>

        <div class="field">
            <label for="has_glitter">Has Glitter:</label>
            <input type="checkbox" id="has_glitter" name="has_glitter" value="1" <?php echo $product['has_glitter'] ? 'checked' : ''; ?>>
        </div>

        <div class="field">
            <label for="image_url">Image-URL</label>
            <input type="text" name="image_url" value="<?php echo htmlspecialchars($product['image_url']); ?>" required><br>
        </div>

        <div class="field">
            <label for="color_group">Color group:</label>
                <select id="color_group" name="color_group" required>
                    <option value="" disabled selected>Kies een kleur groep</option>
                    <option value="pink" <?php echo $product['color_group'] == 'pink' ? 'selected' : ''; ?>>Pink</option>
                    <option value="red" <?php echo $product['color_group'] == 'red' ? 'selected' : ''; ?>>Red</option>
                    <option value="green" <?php echo $product['color_group'] == 'green' ? 'selected' : ''; ?>>Green</option>
                    <option value="blue" <?php echo $product['color_group'] == 'blue' ? 'selected' : ''; ?>>Blue</option>
                    <option value="brown" <?php echo $product['color_group'] == 'brown' ? 'selected' : ''; ?>>Brown</option>
                </select>
        </div>

        <div class="field">
            <label for="color_description">Description</label>
            <input type="text" name="color_description" value="<?php echo htmlspecialchars($product['description']); ?>" required>
        </div>

        <button class="btn" type="submit" name="update_product">Update Product</button>
    </form>

    <!-- Form om product te verwijderen -->
    <form action="edit_product.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
        <button class="btn" type="submit" name="delete_product" onclick="return confirm('Are you sure you want to delete this product?');">Delete Product</button>
    </form>
</body>
</html>

<?php
// Update product

// Update product
if (isset($_POST['update_product'])) {
    $id = intval($_POST['id']);
    $color_name = $_POST['color_name'];
    $color_number = $_POST['color_number'];
    $price = $_POST['price'];
    $has_glitter = isset($_POST['has_glitter']) ? 1 : 0;
    $image_url = $_POST['image_url'];
    $color_group = $_POST['color_group'];
    $description = $_POST['color_description'];

    // Maak een nieuw productobject en werk bij
    $product = new Product();
    $product->setId($id);
    $product->setColorName($color_name);
    $product->setColorNumber($color_number);
    $product->setPrice($price);
    $product->setHasGlitter($has_glitter);
    $product->setImageUrl($image_url);
    $product->setColorGroup($color_group);
    $product->setColorDescription($description);

    // Werk het product bij
    if ($product->update()) {
        // Redirect naar product detail pagina na update
        header("Location: product_details.php?id=$id");
        exit();
    } else {
        echo "Error: Product could not be updated.";
    }
}

// Delete product
if (isset($_POST['delete_product'])) {
    $id = intval($_POST['id']);

    // Verwijder het product
    if (Product::delete($id)) {
        // Redirect naar de homepage na het verwijderen van het product
        header("Location: index.php");
        exit();
    } else {
        echo "Error: Product could not be deleted.";
    }
}
?>
