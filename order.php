<?php
session_start();

// Verbind met de database
$conn = new mysqli('localhost', 'root', '', 'shop');

// Controleer of de verbinding succesvol is
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Zorg ervoor dat er een sessie is voor de cart items
if (!isset($_SESSION['cart_items'])) {
    die('No items in the cart.');
}

// Haal de winkelwagenitems op uit de sessie
$cartItems = $_SESSION['cart_items'];

// Haal de totaalprijs op die via POST is gestuurd
$total = isset($_POST['cart_total']) ? $_POST['cart_total'] : 0;

// Haal de huidige currency van de gebruiker op
$user_id = $_SESSION['user_id']; // Zorg ervoor dat de user_id beschikbaar is
$sql_currency = "SELECT currency FROM users WHERE id = ?";
$stmt_currency = $conn->prepare($sql_currency);

// Foutcontrole voor queryvoorbereiding
if ($stmt_currency === false) {
    die('Error preparing statement: ' . $conn->error);
}

$stmt_currency->bind_param('i', $user_id);
$stmt_currency->execute();
$stmt_currency->bind_result($current_currency);
$stmt_currency->fetch();

// Sluit de statement om naar de volgende query te kunnen gaan
$stmt_currency->close();

// Bereken de nieuwe currency van de gebruiker
$new_currency = $current_currency - $total;

// Update de currency van de gebruiker in de database
$update_sql = "UPDATE users SET currency = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);

// Foutcontrole voor update query
if ($update_stmt === false) {
    die('Error preparing update statement: ' . $conn->error);
}

$update_stmt->bind_param('di', $new_currency, $user_id);
$update_stmt->execute();

// Sluit de databaseverbinding
$update_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link rel="stylesheet" href="css/order.css">
</head>
<body>
<?php include_once('nav.inc.php'); ?>
    <div class="order-summary">
        <h1>Thank you for ordering at Pink Gellac!</h1>
        <p>Your order is being processed and we will notify you once it is ready!</p>

        <h2>Order Summary</h2>
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
                foreach ($cartItems as $item) {
                    $itemTotal = $item['price'] * $item['quantity'];
                    $orderTotal += $itemTotal;
                    echo "<tr>
                        <td>" . htmlspecialchars($item['color_name']) . " - " . htmlspecialchars($item['color_number']) . "</td>
                        <td>€" . number_format($item['price'], 2) . "</td>
                        <td>" . $item['quantity'] . "</td>
                        <td>€" . number_format($itemTotal, 2) . "</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <p><strong>Total Price: €<?php echo number_format($orderTotal, 2); ?></strong></p>
        <p>Your current currency: €<?php echo number_format($new_currency, 2); ?></p>
    </div>
</body>
</html>
