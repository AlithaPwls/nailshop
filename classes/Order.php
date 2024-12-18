<?php
include_once("Db.php");

class Order {
    public static function createOrder($userId, $totalPrice, $products) {
        $conn = Db::getConnection();
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, products, order_date) VALUES (:user_id, :total_price, :products, NOW())");
        $stmt->bindValue(":user_id", $userId);
        $stmt->bindValue(":total_price", $totalPrice);
        $stmt->bindValue(":products", json_encode($products));
        return $stmt->execute();
    }

    public static function getOrdersByUserId($userId) {
        $conn = Db::getConnection();
        $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY order_date DESC"); // Nieuwste eerst
        $stmt->bindValue(":user_id", $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function clearCartByUserId($userId) {
        $conn = Db::getConnection();
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id");
        $stmt->bindValue(":user_id", $userId);
        return $stmt->execute();
    }

    public static function userHasPurchasedProduct($userId, $productId) {
        $conn = Db::getConnection();
        $stmt = $conn->prepare("
            SELECT COUNT(*)
            FROM orders
            WHERE user_id = :user_id
            AND products LIKE :product_id
        ");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':product_id', '%"product_id":' . $productId . '%', PDO::PARAM_STR); // Zoek als string
        $stmt->execute();
    
        return $stmt->fetchColumn() > 0; // Retourneer true als er minstens 1 resultaat is, dan kan user review schrijven
    }
    
    
    
    
    
}
?>
