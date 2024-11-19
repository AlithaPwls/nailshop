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
        <a href="add_product.php" class="nav-link">Add product</a>
        <a href="view_cart.php" class="cart-btn">View Cart</a>
        <a href="#" class="navbar__currency">Currency - € <?php echo isset($user['currency']) ? number_format($user['currency'], 2, ',', '.'): '€0.00'; ?></a>
        


        <?php if (isset($_SESSION['email'])): ?>
            <a href="profile.php" class="navbar__profile">View Profile</a>
            <a href="logout.php" class="navbar__logout">Hi <?php echo htmlspecialchars($_SESSION['email']); ?>, logout?</a>
        <?php else: ?>
            <a href="login.php" class="navbar__login">Login</a>
        <?php endif; ?>
    </div>
</nav>
