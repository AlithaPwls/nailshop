<?php
session_start();
include_once (__DIR__ . "/classes/Order.php");

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$shipping = 4.95;

// Haal de eerdere bestellingen op
$orders = Order::getOrdersByUserId($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/previous_orders.css">
    <title>Your Previous Orders</title>
</head>
<body>
    <?php include_once('nav.inc.php'); ?>
    <div class="container">
        <h1>Your Previous Orders</h1>

        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <?php 
                    $products = json_decode($order['products'], true); 
                    if ($products === null) {
                        echo "<p>Error decoding products for order ID: " . htmlspecialchars($order['id']) . "</p>";
                        continue;
                    }
                    $orderTotal = 0;
                ?>
                <?php if (is_array($products) && !empty($products)): ?>
                    <div class="order">
                        <h2>Order placed on <?= htmlspecialchars($order['order_date']) ?></h2>
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
                                <?php foreach ($products as $product): ?>
                                    <?php $orderTotal += $product['total_price']; ?>
                                    <tr>
                                        <td><?= htmlspecialchars($product['name']) ?></td>
                                        <td>€<?= number_format($product['price'], 2) ?></td>
                                        <td><?= htmlspecialchars($product['quantity']) ?></td>
                                        <td>€<?= number_format($product['total_price'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <p><strong>Total for this order: €<?= number_format($orderTotal + $shipping, 2) ?></strong></p>
                    </div>
                <?php else: ?>
                    <p>No valid products found for order ID: <?= htmlspecialchars($order['id']) ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No previous orders found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
