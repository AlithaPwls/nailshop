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



// Haal de user ID op
$user_id = $_SESSION['user_id'];

// Verwijder product als de verwijderknop is ingedrukt
if (isset($_POST['remove_product'])) {
    $product_id = $_POST['remove_product'];

    // Verwijder het product uit de winkelwagen
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param('ii', $user_id, $product_id);

    if ($stmt->execute()) {
        // Refresh de pagina om de verwijdering te verwerken
        header('Location: view_cart.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Haal de producten in de winkelwagen van de gebruiker op
$sql = "SELECT p.id, p.color_name, p.color_number, p.price, p.image_url, c.quantity 
        FROM cart AS c
        JOIN products AS p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Products ophalen
$cartItems = [];
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}
// Sluit de databaseverbinding
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/view_cart.css">
    <title>Your Cart</title>
</head>
<body>
    <?php include_once('nav.inc.php'); ?>
    
    <div class="cart-container">
        <h1>Your Cart</h1>
        
        <?php if (empty($cartItems)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <form action="view_cart.php" method="POST">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($cartItems as $item):
                            $itemTotal = $item['price'] * $item['quantity'];
                            $total += $itemTotal;
                        ?>
                        <tr>
                            <td class="product-info">
                                <img src="<?php echo $item['image_url']; ?>" alt="Product Image">
                                <?php echo htmlspecialchars($item['color_name']) . " - " . htmlspecialchars($item['color_number']); ?>
                            </td>
                            <td>€<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>€<?php echo number_format($itemTotal, 2); ?></td>
                            <td>
                                <!-- De vuilbakknop voor verwijdering -->
                                <button type="submit" name="remove_product" value="<?php echo $item['id']; ?>">
                                    ❌
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="cart-total">
                    <p>Shipping Cost: €4.95</p>
                    <p>Total: €<?php echo number_format($total + 4.95, 2); ?></p>
                </div>

                <div class="checkout">
                    <a href="checkout.php">Proceed to Checkout</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
