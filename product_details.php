<?php
session_start();

// Verbind met de database
$conn = new mysqli('localhost', 'root', '', 'shop');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Haal product-ID op uit de URL
$product_id = $_GET['id'] ?? null;

if ($product_id) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/product_details.css">
    <title><?php echo htmlspecialchars($product['color_name']); ?> - Detail</title>
</head>
<body>
<?php include_once('nav.inc.php'); ?>

<?php if ($product): ?>
    <div class="product-details">
        <div class="product-info">
            <div class="product-image">
                <img src="<?php echo $product['image_url']; ?>" alt="Product Image">
            </div>
            <div class="product-description">
                <h1><?php echo htmlspecialchars($product['color_name']); ?></h1>
                <h3>€<?php echo number_format($product['price'], 2); ?></h3>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <button class="add">Add to cart</button>
            </div>
        </div>
    </div>

    <div class="review">
        <h2>Reviews</h2>
        
        <form action="submit_review.php?id=<?php echo $product['id']; ?>" method="POST">
            <input type="text" name="review" placeholder="Write a review" required>
            <button type="submit">Submit</button>
        </form>
    </div>
<?php else: ?>
    <p>Product niet gevonden.</p>
<?php endif; ?>
</body>
</html>
