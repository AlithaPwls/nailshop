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
    
        // kijken of het product al in cart is
        $stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($existing) {
            // doe plus quantity
            $newQuantity = $existing['quantity'] + 1;
            $stmt = $conn->prepare("UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id");
            $stmt->bindValue(':quantity', $newQuantity, PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        } else {
            // doe plus 1
            $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, 1)");
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        }
    
        return $stmt->execute();
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
