<?php
session_start();

include_once (__DIR__ . "/classes/Products.php");
include_once (__DIR__ . "/classes/Review.php");
include_once (__DIR__ . "/classes/Order.php");

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

// Controleer of de gebruiker dit product heeft gekocht
$user_id = $_SESSION['user_id'];
$hasPurchased = Order::userHasPurchasedProduct($user_id, $product_id);

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
                <p><?= htmlspecialchars($product['description']); ?></p>
                <h3>€<?= number_format($product['price'], 2); ?></h3>
                <button class="add" data-product-id="<?= $product['id']; ?>">Add to cart</button>
                <?php if ($_SESSION['is_admin'] == 1): ?>
                        <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="edit-product-btn">Edit Product</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="reviews-section">
        <h2>Reviews</h2>

        <?php if ($hasPurchased): ?>
            <form id="review-form">
                <textarea id="review-text" placeholder="Write a review..." required></textarea>
                <button type="submit">Submit</button>
            </form>
        <?php else: ?>
            <p>You can only write a review if you have purchased this product.</p>
        <?php endif; ?>

        <!-- Bestaande reviews weergeven -->
        <div class="reviews-container">
            <?php foreach ($reviews as $review): ?>
                <div class="review-item">
                    <h4><?= htmlspecialchars($review['email']); ?></h4>
                    <small><?= htmlspecialchars($review['created_at']); ?></small>
                    <p><?= htmlspecialchars($review['text']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
document.querySelector('.add').addEventListener('click', function (event) {
    event.preventDefault(); // Voorkomt de standaardactie

    const productId = this.dataset.productId; // Haal het product-ID op
    this.textContent = '🛒✅'; // Update knoptekst
    this.disabled = true; // Deactiveer de knop

    // Verstuur een AJAX-aanroep naar add_to_cart.php
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Product successfully added to cart!');
        } else {
            console.error('Failed to add product to cart: ' + data.error);
            this.textContent = 'Add to cart'; // Reset knop
            this.disabled = false; // Activeer de knop opnieuw
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while adding the product to your cart.');
        this.textContent = 'Add to cart'; // Reset knop
        this.disabled = false; // Activeer de knop opnieuw
    });
});
</script>

<script>
document.getElementById('review-form')?.addEventListener('submit', function(e) {
    e.preventDefault();

    const reviewText = document.getElementById('review-text').value;
    const productId = <?= json_encode($product['id']); ?>;

    fetch('submit_review.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ text: reviewText, product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const reviewsContainer = document.querySelector('.reviews-container');
            const newReview = document.createElement('div');
            newReview.classList.add('review-item');
            newReview.innerHTML = `
                <h4>${data.user_email}</h4>
                <small>${data.created_at}</small>
                <p>${data.text}</p>
            `;
            reviewsContainer.appendChild(newReview);
            document.getElementById('review-text').value = '';
        } else {
            alert('Failed to submit review: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting your review.');
    });
});
</script>


</body>
</html>
