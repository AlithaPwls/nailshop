<?php
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit(); // Stop verdere uitvoering na redirect
}

// Laad de benodigde klassen
include_once (__DIR__ . "/classes/User.php");
require("/Applications/XAMPP/xamppfiles/htdocs/nailshop/classes/Products.php");
echo "Products.php is succesvol geladen!";
exit;
include_once (__DIR__ . "/classes/Db.php");

// Haal de user_id uit de sessie
$user_id = $_SESSION['user_id'];

// Haal de gebruikersinformatie op
$user = User::getById($user_id);

// Verbind met de database voor productgegevens
$conn = Db::getConnection();

// Haal willekeurige producten op
$sql = "SELECT * FROM products ORDER BY RAND()";
$result = $conn->query($sql);

if ($result->rowCount() > 0) {
    $products = $result->fetchAll(PDO::FETCH_ASSOC);
} else {
    $products = [];
}

// Controleer of een kleurcategorie of glitter is geselecteerd
$colorgroup = $_GET['color_group'] ?? 'all';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Nail Shop</title>
</head>
<body>
    <!-- Navigatie -->
    <?php include_once('nav.inc.php'); ?>

    <!-- Popup voor meldingen -->
    <div id="popup" class="popup">
        <p id="popup-message"></p>
    </div>

    <!-- Filters voor producten -->
    <div class="filters">
        <span>Categories:</span>
        <a href="?color_group=all" class="filter-btn <?= ($colorgroup === 'all') ? 'active' : ''; ?>">All</a>
        <a href="?color_group=pink" class="filter-btn <?= ($colorgroup === 'pink') ? 'active' : ''; ?>">Pink</a>
        <a href="?color_group=red" class="filter-btn <?= ($colorgroup === 'red') ? 'active' : ''; ?>">Red</a>
        <a href="?color_group=green" class="filter-btn <?= ($colorgroup === 'green') ? 'active' : ''; ?>">Green</a>
        <a href="?color_group=blue" class="filter-btn <?= ($colorgroup === 'blue') ? 'active' : ''; ?>">Blue</a>
        <a href="?color_group=brown" class="filter-btn <?= ($colorgroup === 'brown') ? 'active' : ''; ?>">Brown</a>
        <a href="?color_group=glitter" class="filter-btn glitter-btn <?= ($colorgroup === 'glitter') ? 'active' : ''; ?>">Glitters</a>
    </div>

    <!-- Productlijst -->
    <div class="products">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <?php if (
                    ($colorgroup === 'all') || 
                    ($colorgroup === $product['color_group']) || 
                    ($colorgroup === 'glitter' && $product['has_glitter'])
                ): ?>
                    <a href="product_details.php?id=<?= $product['id']; ?>">
                        <article>
                            <img src="<?= htmlspecialchars($product['image_url']); ?>" alt="Product image">
                            <h2><?= htmlspecialchars($product['color_name']) . " - " . htmlspecialchars($product['color_number']); ?></h2>
                            <h3>€<?= number_format($product['price'], 2); ?></h3>
                            <button class="add" data-product-id="<?= $product['id']; ?>">Add to cart</button>
                        </article>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; <?= date('Y'); ?> Nail Shop. All rights reserved.</p>
    </footer>

    <!-- Scroll naar boven knop -->
    <button id="back-to-top" onclick="scrollToTop()">⬆</button>

    <!-- JavaScript -->
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

        // Voeg product toe aan winkelwagen
        document.querySelectorAll('.add').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                const productId = this.dataset.productId;

                this.textContent = '🛒✅';
                this.disabled = true;

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
                        console.log('Product added to cart!');
                    } else {
                        console.log('Failed to add product. ' + data.error);
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
