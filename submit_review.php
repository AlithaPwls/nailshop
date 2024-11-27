<?php
session_start();
header('Content-Type: application/json');

include_once('classes/Review.php');


// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    echo json_encode(['success' => false, 'error' => 'User not logged in.']);
    exit;
}

// Verkrijg de POST-data
$data = json_decode(file_get_contents('php://input'), true);
$product_id = $data['product_id'] ?? null;
$review_text = $data['review'] ?? null;
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email']; // Haal de gebruikersnaam op

// Controleer of de vereiste data aanwezig is
if (!$product_id || !$review_text || !$user_id) {
    echo json_encode(['success' => false, 'error' => 'Invalid input data.']);
    exit;
}

// Maak een nieuwe Review instantie en sla de review op
try {
    $review = new Review($review_text, $product_id, $user_id);
    $review->save();
    echo json_encode([
        'success' => true,
        'text' => htmlspecialchars($review_text),
        'user_email' => htmlspecialchars($email),
        'created_at' => $review->getCreatedAt()
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
