<?php
session_start();
header('Content-Type: application/json');

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    echo json_encode(['success' => false, 'error' => 'User not logged in.']);
    exit;
}

// Verbind met de database
$conn = new mysqli('localhost', 'root', '', 'shop');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed.']);
    exit;
}

// Verkrijg de POST-data
$data = json_decode(file_get_contents('php://input'), true);
$product_id = $data['product_id'] ?? null;
$review_text = $data['review'] ?? null;
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email']; // Haal de gebruikersnaam op

if (!$product_id || !$review_text || !$user_id) {
    echo json_encode(['success' => false, 'error' => 'Invalid input data.']);
    exit;
}

// Voeg de review toe aan de database
$stmt = $conn->prepare('INSERT INTO review (text, products_id, users_id, created_at) VALUES (?, ?, ?, NOW())');
$stmt->bind_param('sii', $review_text, $product_id, $user_id);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'text' => htmlspecialchars($review_text),
        'user_email' => htmlspecialchars($email),
        'created_at' => date('d-m-Y')
    ]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
