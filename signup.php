<?php

    // wait for user
    if(!empty($_POST)){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $options = [
            'cost' => 12,
        ];

        $hash = password_hash($password, PASSWORD_DEFAULT, $options); //iedereen met hetzelfde wachtwoord krijgt een andere hash, dit gebruiken op webshop
        $conn = new PDO('mysql:host=localhost;dbname=shop', 'root', '');
        $statement = $conn->prepare('INSERT INTO users (email, password) VALUES (:email, :password)'); //niet $email gebruiken in values, anders sql injectie
        $statement->bindValue(':email', $email); //beveiligd voor SQL injectie
        $statement->bindValue(':password', $hash);
        $statement->execute();
    }

    

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/signup.css">
    <title>Sign Up</title>
</head>
<body>

    <h2>Sign Up</h2>

    <?php if(isset($error)): ?>
        <div class="form__error">
            <p>Sorry, there was an error with your signup. Please try again.</p>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="email">Enter your email</label>
        <input type="text" id="email" name="email" required>

        <label for="password">Enter your password</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Sign Up">
    </form>

</body>
</html>
