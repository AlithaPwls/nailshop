<?php
include_once("Db.php");

class Cart {
    public static function getByUserId($userId) {
        $conn = Db::getConnection();
        $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = :user_id");
        $stmt->bindValue(":user_id", $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function addToCart($userId, $productId) {
        $conn = Db::getConnection();
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id) VALUES (:user_id, :product_id)");
        $stmt->bindValue(":user_id", $userId, PDO::PARAM_INT);
        $stmt->bindValue(":product_id", $productId, PDO::PARAM_INT);
        return $stmt->execute();  // Voer de query uit en retourneer of het is gelukt
    }

    public static function clearCartByUserId($userId) {
        $conn = Db::getConnection();
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id");
        $stmt->bindValue(":user_id", $userId);
        return $stmt->execute();
    }

    public static function removeProductFromCart($userId, $productId)
{
    $conn = Db::getConnection();
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
    return $stmt->execute();
}

public static function getCartItemsByUserId($userId)
{
    $conn = Db::getConnection();
    $sql = "SELECT p.id, p.color_name, p.color_number, p.price, p.image_url, c.quantity 
            FROM cart AS c
            JOIN products AS p ON c.product_id = p.id
            WHERE c.user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
?>
