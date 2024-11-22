<?php
session_start();
if ($_SESSION['loggedin'] !== true || (int)$_SESSION['is_admin'] !== 1) {
    header('Location: login.php');
    exit();
}

$product_id = $_GET['id'] ?? null; // Haal de ID uit de URL
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
    // Haal productdata op uit de database
    $conn = new mysqli('localhost', 'root', '', 'shop');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc() ?: $product;
    $conn->close();
}

?>

<!DOCTYPE html>
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
            <label for="color_group">Color Group:</label>
            <input type="text" name="color_group" value="<?php echo htmlspecialchars($product['color_group']); ?>" required>
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
if (isset($_POST['update_product'])) {
    $id = intval($_POST['id']);
    $color_name = $_POST['color_name'];
    $color_number = $_POST['color_number'];
    $price = $_POST['price'];
    $has_glitter = isset($_POST['has_glitter']) ? 1 : 0;
    $image_url = $_POST['image_url'];
    $color_group = $_POST['color_group'];
    $description = $_POST['color_description'];

    // Verbind met de database en werk het product bij
    $conn = new mysqli('localhost', 'root', '', 'shop');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE products SET color_name = ?, color_number = ?, price = ?, has_glitter = ?, image_url = ?, color_group = ?, description = ? WHERE id = ?");
    $stmt->bind_param("sssisssi", $color_name, $color_number, $price, $has_glitter, $image_url, $color_group, $description, $id);

    if ($stmt->execute()) {
        // Redirect naar product detail pagina na update
        header("Location: product_details.php?id=$id");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}

// Delete product
if (isset($_POST['delete_product'])) {
    $id = intval($_POST['id']);

    // Verbind met de database en verwijder het product
    $conn = new mysqli('localhost', 'root', '', 'shop');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect naar de homepage na het verwijderen van het product
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}
?>
