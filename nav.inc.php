<nav>
    <div class="nav-left">
        <h1>Pink Gellac</h1>
    </div>
    <div class="nav-right">
        <a href="add_product.php" class="nav-link">Voeg Product Toe</a>
        <a href="#" class="cart-btn">View Cart - <?php echo isset($user['currency']) ? number_format($user['currency'], 2, ',', '.'): '€0.00'; ?></a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</nav>
