 <link rel="stylesheet" href="css/nav.css">
 <nav>
    <div class="nav-left">
        <a class="pg" href="index.php">Pink Gellac</a>
    </div>
    <div class="nav-right">
        <a href="add_product.php" class="nav-link">Voeg Product Toe</a>
        <a href="#" class="cart-btn">View Cart - € <?php echo isset($user['currency']) ? number_format($user['currency'], 2, ',', '.'): '€0.00'; ?></a>
        <a href="logout.php" class="navbar__logout">Hi <?php echo htmlspecialchars($_SESSION['email']); ?>, logout?</a>
    </div>
</nav>
