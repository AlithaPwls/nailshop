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
            // Haal de currency op uit de database
            include 'classes/Db.php';
            $conn = new mysqli('localhost', 'root', '', 'shop');
            /*if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }*/
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT currency FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $stmt->bind_result($currency);
            $stmt->fetch();
            $conn->close();
            echo number_format($currency, 2, ',', '.');
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
