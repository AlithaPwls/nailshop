<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'classes/Db.php';
include_once 'classes/User.php';
?>

<link rel="stylesheet" href="css/nav.css">

<nav>
    <div class="nav-left">
        <a class="pg" href="index.php">Pink Gellac</a>
    </div>
    <div class="nav-right">       
         <!-- Zoekformulier -->
        <form action="search_results.php" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search by color name or number" class="search-input">
            <button type="submit" class="search-btn">Search</button>
        </form>
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
            <a href="add_product.php" class="nav-link">Add product</a>
        <?php endif; ?>        
        <a href="view_cart.php" class="cart-btn">View Cart</a>
        <a href="#" class="navbar__currency">Currency - € 
            <?php
            // Controleer of de gebruiker is ingelogd
            if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
                try {
                    // Verbind met de database
                    $conn = Db::getConnection();

                    // Haal de currency op
                    $stmt = $conn->prepare("SELECT currency FROM users WHERE id = :id");
                    $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
                    $stmt->execute();

                    $result = $stmt->fetch();
                    if ($result && isset($result['currency'])) {
                        echo number_format($result['currency'], 2, ',', '.');
                    } else {
                        echo "Not found.";
                    }
                } catch (Exception $e) {
                    echo "Error: " . htmlspecialchars($e->getMessage());
                }
            } else {
                echo "User not logged in.";
            }
            ?>
        </a>

        <?php if (isset($_SESSION['email'])): ?>
            <a href="profile.php" class="navbar__profile">View Profile</a>
            <a href="logout.php" class="navbar__logout">Hi <?php echo htmlspecialchars($_SESSION['firstname']); ?>, logout?</a>
        <?php else: ?>
            <a href="login.php" class="navbar__login">Login</a>
        <?php endif; ?>
    </div>
</nav>
