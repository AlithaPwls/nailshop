<?php
include_once("Db.php");

class Review {
    private $text;
    private $product_id;
    private $user_id;

    public function __construct($text, $product_id, $user_id) {
        $this->text = $text;
        $this->product_id = $product_id;
        $this->user_id = $user_id;
    }

    public function save() {
        $conn = Db::getConnection();
        $stmt = $conn->prepare("
            INSERT INTO review (text, products_id, users_id, created_at) 
            VALUES (:text, :product_id, :user_id, NOW())
        ");
        $stmt->bindValue(':text', $this->text, PDO::PARAM_STR);
        $stmt->bindValue(':product_id', $this->product_id, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
    
        if (!$stmt->execute()) {
            throw new Exception("Failed to save the review.");
        }
    
        return [
            'text' => htmlspecialchars($this->text),
            'created_at' => date("Y-m-d"),
        ];
    }
    

    public static function getReviewsByProductId($product_id) {
        $conn = Db::getConnection();
        $stmt = $conn->prepare("
            SELECT r.text, r.created_at, u.email 
            FROM review r 
            INNER JOIN users u ON r.users_id = u.id 
            WHERE r.products_id = :product_id 
            ORDER BY r.created_at DESC
        ");
        $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
