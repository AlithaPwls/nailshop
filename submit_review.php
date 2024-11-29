<?php
session_start();
include_once(__DIR__ . "/classes/Review.php");

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

header('Content-Type: application/json');

try {
    // Ontvang en decodeer JSON-gegevens
    $data = json_decode(file_get_contents('php://input'), true);
    if (empty($data['text']) || empty($data['product_id'])) {
        throw new Exception("Invalid input");
    }

    // Haal user-ID op uit de sessie
    $user_id = $_SESSION['user_id']; // Zorg dat deze in je sessie zit
    $text = $data['text'];
    $product_id = $data['product_id'];

    // Sla de review op
    $review = new Review($text, $product_id, $user_id);
    $savedReview = $review->save();

    // Return een JSON-response met de nieuwe review
    echo json_encode([
        'success' => true,
        'text' => $savedReview['text'],
        'created_at' => $savedReview['created_at'],
        'user_email' => $_SESSION['email'] // Zorg dat de email in je sessie staat
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
