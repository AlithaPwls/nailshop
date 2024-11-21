<?php
session_start();
if ($_SESSION['loggedin'] !== true || (int)$_SESSION['is_admin'] !== 1) {
    header('Location: login.php');
    exit();
}

$product_id = $_GET['id'] ?? null; // Haal de ID uit de URL

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
    $product = $result->fetch_assoc();
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
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>"> <!-- Verberg de ID in het formulier -->
        
        <div class="field">
            <label for="color_name">Color Name</label>
            <input type="text" name="color_name" value="<?php echo $product['color_name']; ?>" required><br>
        </div>

        <div class="field">
            <label for="price">Price</label>
            <input type="text" name="price" value="<?php echo $product['price']; ?>" required><br>
        </div>

        <button class="btn" type="submit" name="update_product">Update Product</button>
    </form>

    <!-- Form om product te verwijderen -->
    <form action="edit_product.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <button class="btn" type="submit" name="delete_product" onclick="return confirm('Are you sure you want to delete this product?');">Delete Product</button>
    </form>
</body>
</html>

<?php
// Update product
if (isset($_POST['update_product'])) {
    $id = $_POST['id'];  // Haal de ID uit de POST-data
    $color_name = $_POST['color_name'];
    $price = $_POST['price'];

    // Verbind met de database en werk het product bij
    $conn = new mysqli('localhost', 'root', '', 'shop');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE products SET color_name = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssi", $color_name, $price, $id);

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
    $id = $_POST['id'];

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
