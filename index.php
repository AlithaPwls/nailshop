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
                        <button class="add">Add to cart</button>
                    </article>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</div>

    </div>
</body>
</html>