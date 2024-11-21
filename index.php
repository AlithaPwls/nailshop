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

    <div id="popup" class="popup">
        <p id="popup-message"></p>
    </div>

    <div class="filters">
        <span>Categories:</span>
        <a href="?color_group=all" class="filter-btn <?php echo ($colorgroup === 'all') ? 'active' : ''; ?>">All</a>
        <a href="?color_group=pink" class="filter-btn <?php echo ($colorgroup === 'pink') ? 'active' : ''; ?>">Pink</a>

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

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Nail Shop. All rights reserved.</p>
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
    button.addEventListener('click', function (event) {
        event.preventDefault(); // Voorkom dat de pagina opnieuw wordt geladen bij klik

        const productId = this.dataset.productId;
        console.log('product ID:', productId);

        // Verander de tekst van de knop naar "Added to cart"
        this.textContent = '🛒✅';
        this.disabled = true; // Zet de knop uit zodat deze niet opnieuw aangeklikt kan worden

        // Verstuur het product-ID naar de server met AJAX
        fetch('add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(response => response.json())
        .then(data => {
            // Alleen tonen dat het product is toegevoegd, zonder pop-up
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