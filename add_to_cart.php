<?php
session_start();

include_once (__DIR__ . "/classes/cart.php");

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'You must be logged in.']);
    exit;
}

// Ontvang de JSON-input
$data = json_decode(file_get_contents('php://input'), true);
$product_id = $data['product_id'] ?? null;

if (!$product_id) {
    echo json_encode(['success' => false, 'error' => 'Invalid product ID.']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Voeg het product toe aan het winkelmandje via de Cart-klasse
if (Cart::addToCart($user_id, $product_id)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to add to cart.']);
}
?>
