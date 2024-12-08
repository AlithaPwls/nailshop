<?php
session_start();

// Controleer of de gebruiker is ingelogd
if ($_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Cart.php");

// Haal de gebruiker op via de User-class
$user = User::getByEmail($_SESSION['email']);
if (!$user) {
    echo "User not found.";
    exit();
}

// Haal de producten in de winkelwagen op via de Cart-class
$cartItems = Cart::getCartItemsByUserId($user['id']);

// Verwijder product als de verwijderknop is ingedrukt
if (isset($_POST['remove_product'])) {
    $product_id = $_POST['remove_product'];

    // Verwijder het product uit de winkelwagen via de Cart-class
    if (Cart::removeProductFromCart($user['id'], $product_id)) {
        // Refresh de pagina om de verwijdering te verwerken
        header('Location: view_cart.php');
        exit();
    } else {
        echo "Error: Could not remove product.";
    }
}

// Controleer of de gebruiker probeert door te gaan naar de checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_total'])) {
    $cartTotal = floatval($_POST['cart_total']); // Totale prijs uit het formulier
    $userCurrency = floatval($user['currency']); // Haal currency op van de gebruiker

    // Controleer of de gebruiker voldoende currency heeft
    if ($userCurrency < $cartTotal) {
        // Toon een alert en blijf op dezelfde pagina
        echo "<script>alert('Not enough currency to complete the purchase. Please add more funds.');</script>";
    } else {
        // Verlaag de currency van de gebruiker
        $newCurrency = $userCurrency - $cartTotal;
        $updated = User::updateCurrency($user['id'], $newCurrency);

        if ($updated) {
            // Sla de bestelling op in de sessie en ga door naar de checkout
            $_SESSION['cart_items'] = $cartItems;
            $_SESSION['cart_total'] = $cartTotal;
            header('Location: order.php');
            exit();
        } else {
            echo "<script>alert('Error updating your currency. Please try again later.');</script>";
        }
    }
}
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
                                <span><?php echo htmlspecialchars($item['color_name']) . " - " . htmlspecialchars($item['color_number']); ?></span>
                            </td>
                            <td>€<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>€<?php echo number_format($itemTotal, 2); ?></td>
                            <td>
                                <button type="submit" name="remove_product" value="<?php echo $item['id']; ?>">❌</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="cart-total">
                    <p>Shipping Cost: €4.95</p>
                    <p>Total: €<?php echo number_format($total + 4.95, 2); ?></p>
                </div>
            </form>

            <!-- Nieuwe form voor de checkout -->
            <form action="view_cart.php" method="POST">
                <input type="hidden" name="cart_total" value="<?php echo number_format($total + 4.95, 2); ?>">
                <button type="submit" class="checkout-btn">Proceed to Checkout</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
