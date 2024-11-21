<?php
session_start();

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

// Databaseverbinding
$conn = new mysqli('localhost', 'root', '', 'shop');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed.']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Voeg het product toe aan het winkelmandje
$stmt = $conn->prepare("INSERT INTO cart (user_id, product_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $product_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to add to cart.']);
}

$stmt->close();
$conn->close();

?>
