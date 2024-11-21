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

// Kleurtjes willekeurig rangschikken
$sql = "SELECT * FROM products ORDER BY RAND()";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $products = [];
}
$conn->close();

// Controleer of een kleurcategorie of glitter is geselecteerd
$colorgroup = $_GET['color_group'] ?? 'all';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Nail shop</title>
</head>
<body>
    <?php include_once('nav.inc.php'); ?>

    <div class="filters">
        <span>Categories:</span>
        <a href="?color_group=all" class="filter-btn <?php echo ($colorgroup === 'all') ? 'active' : ''; ?>">All</a>
        <a href="?color_group=red" class="filter-btn <?php echo ($colorgroup === 'red') ? 'active' : ''; ?>">Red</a>
        <a href="?color_group=green" class="filter-btn <?php echo ($colorgroup === 'green') ? 'active' : ''; ?>">Green</a>
        <a href="?color_group=blue" class="filter-btn <?php echo ($colorgroup === 'blue') ? 'active' : ''; ?>">Blue</a>
        <a href="?color_group=brown" class="filter-btn <?php echo ($colorgroup === 'brown') ? 'active' : ''; ?>">Brown</a>
        <a href="?color_group=glitter" class="filter-btn glitter-btn <?php echo ($colorgroup === 'glitter') ? 'active' : ''; ?>">Glitters</a>
    </div>
    <div class="products">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <?php if (
                ($colorgroup === 'all') || 
                ($colorgroup === $product['color_group']) || 
                ($colorgroup === 'glitter' && $product['has_glitter']) ||
                ($product['color_group'] === $colorgroup && $product['has_glitter'])
            ): ?>
                <a href="product_details.php?id=<?php echo $product['id']; ?>">
                    <article>
                        <img src="<?php echo $product['image_url']; ?>" alt="Product image">
                        <h2><?php echo $product['color_name'] . " - " . $product['color_number']; ?></h2>
                        <h3>€<?php echo number_format($product['price'], 2); ?></h3>
                        <button class="add" data-product-id="<?php echo $product['id']; ?>">Add to cart</button>
                        </article>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</div>

    </div>

    <footer style="background-color: #f9f9f9; color: #333; text-align: center; padding: 20px; font-size: 14px;">
    <div>
        <p>&copy; 2024 Pink Gellac. Alle rechten voorbehouden.</p>
        <nav style="margin-top: 10px;">
            <a href="privacy.php" style="margin-right: 15px; color: #555; text-decoration: none;">Privacybeleid</a>
            <a href="terms.php" style="margin-right: 15px; color: #555; text-decoration: none;">Algemene voorwaarden</a>
            <a href="contact.php" style="color: #555; text-decoration: none;">Contact</a>
        </nav>
        <p style="margin-top: 10px;">Volg ons: 
            <a href="https://www.instagram.com" target="_blank" style="color: #555; text-decoration: none; margin-left: 5px;">Instagram</a> | 
            <a href="https://www.facebook.com" target="_blank" style="color: #555; text-decoration: none; margin-left: 5px;">Facebook</a>
        </p>
    </div>
</footer>


    <button id="back-to-top" onclick="scrollToTop()">⬆</button>

<script>
    // Laat de knop zien/verbergen op basis van de scrollpositie
    window.onscroll = function () {
        const backToTopButton = document.getElementById('back-to-top');
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            backToTopButton.style.display = "block";
        } else {
            backToTopButton.style.display = "none";
        }
    };

    // Scroll naar de bovenkant van de pagina
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>
<script>
    document.querySelectorAll('.add').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.dataset.productId;
            console.log('product ID:', productId);

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
    });
</script>

</body>
</html>