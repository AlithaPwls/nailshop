<?php
class Review {
    private $text;
    private $product_id;
    private $user_id;
    private $created_at;

    public function __construct($text, $product_id, $user_id) {
        $this->text = $text;
        $this->product_id = $product_id;
        $this->user_id = $user_id;
    }

    public function save() {
        // Maak verbinding met de database
        $conn = new mysqli('localhost', 'root', '', 'shop');
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Voeg de review toe aan de database
        $stmt = $conn->prepare("INSERT INTO review (products_id, users_id, text, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param('iis', $this->product_id, $this->user_id, $this->text);
        if (!$stmt->execute()) {
            throw new Exception("Failed to save review.");
        }

        $this->created_at = date("d-m-Y", strtotime('now')); // Date when review is added

        $conn->close();
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    // Methode om reviews op te halen op basis van product-ID
    public static function getReviewsByProductId($product_id) {
        $conn = new mysqli('localhost', 'root', '', 'shop');
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT review.text, review.created_at, users.email FROM review 
                                INNER JOIN users ON review.users_id = users.id
                                WHERE review.products_id = ?");
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }

        $conn->close();
        return $reviews;
    }
}
?>
