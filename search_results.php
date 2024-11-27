<?php
session_start();


include_once (__DIR__ . "/classes/Products.php");

$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Haal de zoekresultaten op via de Product-klasse
$products = Product::searchProducts($search_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/search_results.css">
    <title>Search Results</title>
</head>
<body>
    <?php include_once('nav.inc.php'); ?>
    <h1>Search Results for: "<?php echo htmlspecialchars($search_query); ?>"</h1>

    <div class="product-details">
        <div class="products">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <article class="product-info">
                        <div class="product-image">
                            <img src="<?php echo $product['image_url']; ?>" alt="Product Image">
                        </div>

                        <div class="product-description">
                            <h3><?php echo htmlspecialchars($product['color_name']); ?></h3>
                            <p>Color Number: <?php echo htmlspecialchars($product['color_number']); ?></p>
                            <p>Price: €<?php echo number_format($product['price'], 2); ?></p>
                            <a href="product_details.php?id=<?php echo $product['id']; ?>" class="add">View Details</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found for "<?php echo htmlspecialchars($search_query); ?>".</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
