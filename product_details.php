<?php
session_start();

include_once (__DIR__ . "/classes/products.php");
include_once (__DIR__ . "/classes/Review.php");


// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

// Haal product-ID op uit de URL
$product_id = $_GET['id'] ?? null;

if (!$product_id) {
    echo "Product not found.";
    exit();
}

// Haal productgegevens op
$product = Product::getById($product_id);
if (!$product) {
    echo "Product not found.";
    exit();
}

// Haal reviews op via de Review-class
$reviews = Review::getReviewsByProductId($product_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/product_details.css">
    <title>Product Details</title>
</head>
<body>
<?php include_once('nav.inc.php'); ?>

<div class="product-details">
    <div class="product-info">
        <div class="product-image">
            <img src="<?= htmlspecialchars($product['image_url']); ?>" alt="Product Image">
        </div>
        <div class="product-description">
            <h1><?= htmlspecialchars($product['color_name']); ?></h1>
            <h3>€<?= number_format($product['price'], 2); ?></h3>
            <p><?= htmlspecialchars($product['description']); ?></p>
            <button class="add" data-product-id="<?= $product['id']; ?>">Add to cart</button>
            <?php if ($_SESSION['is_admin'] == 1): ?>
                    <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="edit-product-btn">Edit Product</a>
                <?php endif; ?>
        </div>
    </div>
</div>

<div class="reviews-section">
    <h2>Reviews</h2>

    <!-- Formulier om een review te plaatsen -->
    <form id="review-form">
        <textarea id="review-text" placeholder="Write a review..." required></textarea>
        <button type="submit">Submit</button>
    </form>

</div>


</div>

</body>
</html>
