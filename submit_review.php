<?php
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    // Als de gebruiker niet ingelogd is, redirect naar loginpagina
    header("Location: login.php");
    exit;
}

// Verbind met de database
$conn = new mysqli('localhost', 'root', '', 'shop');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Haal het product-ID en de gebruikers-ID op
$product_id = $_GET['id'] ?? null;
$user_id = $_SESSION['user_id']; // Zorg ervoor dat je user_id opslaat bij login

if ($product_id && $user_id && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // Haal de reviewtekst op uit de POST-data
    $review_text = $_POST['review'] ?? '';

    if ($review_text) {
        // Bereid de SQL-query voor om de review in de database in te voegen
        $stmt = $conn->prepare("INSERT INTO review (text, products_id, users_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $review_text, $product_id, $user_id);

        if ($stmt->execute()) {
            // Succesvolle invoeging
            header("Location: product_details.php?id=" . $product_id); // Redirect naar de productpagina
            exit;
        } else {
            echo "Er is een fout opgetreden bij het toevoegen van de review.";
        }

        $stmt->close();
    } else {
        echo "Je moet een review schrijven.";
    }
}

$conn->close();
?>
