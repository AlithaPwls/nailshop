<?php
session_start();

include_once (__DIR__ . "/classes/Order.php");
include_once (__DIR__ . "/classes/Cart.php");
include_once (__DIR__ . "/classes/User.php");


// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Haal de winkelwagenitems en totaal op
$cartItems = isset($_SESSION['cart_items']) ? $_SESSION['cart_items'] : [];
$total = isset($_POST['cart_total']) ? $_POST['cart_total'] : 0;

// Haal de gebruiker op uit de database
$user = User::getById($user_id);

if ($user && $user['currency'] >= $total) {
    // Verminder de currency van de gebruiker
    $newCurrency = $user['currency'] - $total;

    if (User::updateCurrency($user_id, $newCurrency)) {
        // Zet winkelwagenitems om naar JSON
        $products = [];
        foreach ($cartItems as $item) {
            $products[] = [
                'product_id' => $item['id'],
                'name' => $item['color_name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total_price' => $item['price'] * $item['quantity'],
                'image_url' => $item['image_url']
            ];
        }

        // Maak de bestelling aan
        if (Order::createOrder($user_id, $total, $products)) {
            // Verwijder de winkelwagenitems
            Cart::clearCartByUserId($user_id);
            $orderProcessed = true;
        } else {
            $error = "Error saving order. Please try again.";
        }
    } else {
        $error = "Error updating currency. Please try again.";
    }
} else {
    $error = "Insufficient funds. Please add more funds to your account.";
}


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
        <?php if (isset($orderProcessed) && $orderProcessed): ?>
            <h1>Thank you for your order! 🩷</h1>
            <h3>You'll get notified when your package is on its way!</h3>

            <h4>Here are the details of your purchase:</h4>

            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Color Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="Product Image" style="width: 100px; height: auto;">
                            </td>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td>€<?= number_format($product['price'], 2) ?></td>
                            <td><?= htmlspecialchars($product['quantity']) ?></td>
                            <td>€<?= number_format($product['total_price'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="order-summary">
                <p><strong>Shipping Cost:</strong> €4.95</p>
                <p><strong>Total:</strong> €<?= number_format($total + 4.95, 2) ?></p>
            </div>

        <?php else: ?>
            <h1>Error</h1>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
