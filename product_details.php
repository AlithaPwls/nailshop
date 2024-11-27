<?php
session_start();

// Include de Review class
include_once('classes/Review.php');

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
        // Gebruik de Review class om de reviews op te halen
        $reviews = Review::getReviewsByProductId($product_id);
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
        <form id="review-form">
            <div class="review-input-container">
                <input type="text" name="review" id="review" placeholder="Write a review" required>
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
    document.getElementById('review-form').addEventListener('submit', function (e) {
        e.preventDefault(); // Voorkomt het standaardformuliergedrag

        const reviewInput = document.getElementById('review');
        const reviewText = reviewInput.value.trim(); // Haal de ingevulde reviewtekst op
        const productId = <?php echo json_encode($product_id); ?>;

        if (!reviewText) {
            alert('Please write a review before submitting.');
            return;
        }

        // AJAX-verzoek om de review te verzenden
        fetch('submit_review.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ product_id: productId, review: reviewText })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const noReviewsText = document.querySelector('.reviews-list p');
                if (noReviewsText && noReviewsText.textContent === 'No reviews yet.') {
                    noReviewsText.remove();
                }
                // Voeg de nieuwe review toe aan de lijst
                const reviewsList = document.querySelector('.reviews-list');
                const newReview = `
                    <div class="review-item">
                        <h4>${data.user_email}</h4>
                        <small>${data.created_at}</small>
                        <p>${data.text}</p>
                    </div>
                `;
                reviewsList.innerHTML += newReview;
                reviewInput.value = ''; // Wis het invoerveld
            } else {
                alert('Failed to submit review: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong. Please try again.');
        });
    });
</script>

</body>
</html>
