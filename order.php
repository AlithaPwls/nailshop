<?php
session_start();

// Maak verbinding met de database
$conn = new mysqli('localhost', 'root', '', 'shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verkrijg de user_id van de ingelogde gebruiker
$user_id = $_SESSION['user_id'];

// Haal de winkelwagenitems op uit de sessie
$cartItems = isset($_SESSION['cart_items']) ? $_SESSION['cart_items'] : [];
$total = isset($_POST['cart_total']) ? $_POST['cart_total'] : 0;

// Haal de huidige currency van de gebruiker op
$query = "SELECT currency FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Als de gebruiker voldoende currency heeft, verwerk de bestelling
if ($user && $user['currency'] >= $total) {
    // Verminder de currency van de gebruiker
    $newCurrency = $user['currency'] - $total;

    // Update de currency in de database
    $updateQuery = "UPDATE users SET currency = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('di', $newCurrency, $user_id);
    if ($stmt->execute()) {
        // Winklewagenitems verwijderen na succesvolle betaling
        $clearCartQuery = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $conn->prepare($clearCartQuery);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        
        echo "<p>Your order has been processed, and your balance has been updated. 🩷</p>";
    } else {
        echo "<p>Error updating currency: " . $conn->error . "</p>";
    }
} else {
    echo "<p>Insufficient funds. Please add more funds to your account.</p>";
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
                <p><strong>Total Price incl. shipping: €<?php echo number_format($orderTotal + 4.95, 2); ?></strong></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
