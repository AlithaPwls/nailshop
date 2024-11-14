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

// Controleer of de verbinding gelukt is
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Haal het product-ID en de gebruikers-ID op
$product_id = $_GET['id'] ?? null;
$user_id = $_SESSION['user_id']; // Zorg ervoor dat je user_id opslaat bij login

// Debug: controleer of het product_id en user_id correct zijn
// var_dump($product_id, $user_id); 

if ($product_id && $user_id && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // Haal de reviewtekst op uit de POST-data
    $review_text = $_POST['review'] ?? '';

    // Debug: controleer of de reviewtekst is ingevuld
    // var_dump($review_text); 

    if ($review_text) {
        // Bereid de SQL-query voor om de review in de database in te voegen
        $stmt = $conn->prepare("INSERT INTO review (text, products_id, users_id) VALUES (?, ?, ?)");
        
        // Controleer of de voorbereiding van de statement is gelukt
        if ($stmt === false) {
            die('Error preparing statement: ' . $conn->error);
        }

        // Bind de parameters voor de query
        $stmt->bind_param("sii", $review_text, $product_id, $user_id);

        // Probeer de query uit te voeren
        if ($stmt->execute()) {
            // Succesvolle invoeging
            header("Location: product_details.php?id=" . $product_id); // Redirect naar de productpagina
            exit;
        } else {
            // Foutmelding bij het uitvoeren van de query
            echo "Er is een fout opgetreden bij het toevoegen van de review: " . $stmt->error;
        }

        // Sluit de statement
        $stmt->close();
    } else {
        // Reviewtekst is leeg
        echo "Je moet een review schrijven.";
    }
} else {
    // Foutmelding als er geen product_id of user_id is
    var_dump($product_id, $user_id);
    echo "Er is een probleem met de opgegeven gegevens.";
}

// Sluit de databaseverbinding
$conn->close();
?>
