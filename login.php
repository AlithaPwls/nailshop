<?php
session_start();
include_once (__DIR__ . "./classes/User.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Authenticatie via de User-class
    $user = User::authenticate($email, $password);

    if ($user) {
        // Zet gebruikersgegevens in de sessie
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email']; // Voeg de e-mail toe aan de sessie
        $_SESSION['firstname'] = $user['firstname'];
        $_SESSION['lastname'] = $user['lastname'];
        $_SESSION['is_admin'] = $user['is_admin']; // Voeg de adminstatus toe aan de sessie

    
        // Doorverwijzen naar de indexpagina
        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid email or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <label for="text">Email</label>
            <input type="text" id="email" name="email" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <p>No account yet? <a href="signup.php">Sign up here</a></p>
    </div>
</body>
</html>
