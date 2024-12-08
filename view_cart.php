<?php
session_start();

// Controleer of de gebruiker is ingelogd
if ($_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}
include_once (__DIR__ . "/classes/User.php");
include_once (__DIR__ . "/classes/Cart.php");


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
            </form>

            <!-- Nieuwe form voor de checkout -->
<form action="order.php" method="POST">
    <!-- Sla de producten en totaal op in de sessie -->
    <input type="hidden" name="cart_total" value="<?php echo number_format($total + 4.95, 2); ?>">

    <?php
    // Sla de winkelwagenitems op in de sessie
    $_SESSION['cart_items'] = $cartItems;
    ?>

    <button type="submit" class="checkout-btn">Proceed to Checkout</button>
</form>

        <?php endif; ?>
    </div>
</body>
</html>