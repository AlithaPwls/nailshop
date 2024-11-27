<?php
session_start();

// Haal de winkelwagenitems op uit de sessie
$cartItems = isset($_SESSION['cart_items']) ? $_SESSION['cart_items'] : [];
$total = isset($_POST['cart_total']) ? $_POST['cart_total'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/order.css">
    <title>Order Summary</title>
</head>
<body>
    <?php include_once('nav.inc.php'); ?>
    
    <div class="order-container">
        <h1>Thank you for ordering at Pink Gellac!</h1>
        <p>Your order is being processed. We'll notify you once it's ready.</p>
        
        <?php if (empty($cartItems)): ?>
            <p>Your order is empty.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $orderTotal = 0;
                    foreach ($cartItems as $item):
                        $itemTotal = $item['price'] * $item['quantity'];
                        $orderTotal += $itemTotal;
                    ?>
                    <tr>
                        <td class="product-info">
                            <img src="<?php echo $item['image_url']; ?>" alt="Product Image">
                            <span><?php echo htmlspecialchars($item['color_name']) . " - " . htmlspecialchars($item['color_number']); ?></span>
                        </td>
                        <td>€<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>€<?php echo number_format($itemTotal, 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="order-total">
                <p><strong>Total Price incl. shipping: €<?php echo number_format($orderTotal, 2); ?></strong></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
