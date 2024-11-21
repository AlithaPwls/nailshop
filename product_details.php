<?php
session_start();

if ($_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

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

// Haal product-ID op uit de URL
$product_id = $_GET['id'] ?? null;

$product = null; // Initializeer de $product variabele

if ($product_id) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc(); // Verkrijg het product

    if ($product) {
        // Haal de reviews voor dit product op
        $reviewStmt = $conn->prepare("SELECT reviews.text, users.email, reviews.created_at FROM review AS reviews 
                                      JOIN users ON reviews.users_id = users.id 
                                      WHERE reviews.products_id = ?");
        $reviewStmt->bind_param("i", $product_id);
        $reviewStmt->execute();
        $reviewResult = $reviewStmt->get_result();
        $reviews = $reviewResult->fetch_all(MYSQLI_ASSOC); // Haal alle reviews op
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/product_details.css">
    <title><?php echo isset($product['color_name']) ? htmlspecialchars($product['color_name']) : 'Product niet gevonden'; ?> - Detail</title>
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
                <button class="add" data-product-id="<?php echo $product['id']; ?>">Add to cart</button>
                <?php if ($_SESSION['is_admin'] == 1): ?>
                    <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="edit-product-btn">Edit Product</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="reviews-section">
        <h2>Reviews</h2>
    
        <!-- Formulier om review in te vullen -->
        <form action="submit_review.php?id=<?php echo $product['id']; ?>" method="POST">
            <div class="review-input-container">
                <input type="text" name="review" placeholder="Write a review" required>
                <button type="submit">Submit</button>
            </div>
        </form>

        <!-- Reviews weergeven -->
        <div class="reviews-list">
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review-item">
                        <h4><?php echo htmlspecialchars($review['email']); ?></h4>
                        <small><?php echo date("d-m-Y", strtotime($review['created_at'])); ?></small>
                        <p><?php echo htmlspecialchars($review['text']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No reviews yet.</p>
            <?php endif; ?>
        </div>
    </div>

<?php else: ?>
    <p>Product niet gevonden.</p>
<?php endif; ?>

<script>
    // Selecteer de "Add to cart" knop
    document.querySelector('.add').addEventListener('click', function () {
        const productId = this.dataset.productId;
        console.log('product ID:', productId); // Log voor debuggen

        // Verstuur het product-ID naar de server
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
                alert('Product added to cart!');
            } else {
                alert('Failed to add product. ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong.');
        });
    });
</script>

</body>
</html>
