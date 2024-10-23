<?php

    // wait for user
    if(!empty($_POST)){
        $firstname = $_POST['firstname']; // Add firstname
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        

        $options = [
            'cost' => 12,
        ];

        $hash = password_hash($password, PASSWORD_DEFAULT, $options); //iedereen met hetzelfde wachtwoord krijgt een andere hash, dit gebruiken op webshop
        $conn = new PDO('mysql:host=localhost;dbname=shop', 'root', '');
        $statement = $conn->prepare('INSERT INTO users (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)');
        $statement->bindValue(':firstname', $firstname);
        $statement->bindValue(':lastname', $lastname);
        $statement->bindValue(':email', $email); //beveiligd voor SQL injectie
        $statement->bindValue(':password', $hash);
        $statement->execute();

        if ($statement->execute()) {
            // Redirect to index.php after successful registration
            header('Location: index.php');
            exit; // Stop further script execution
        } else {
            // Handle error (optional)
            $error = true;
        }
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

        <label for="firstname">Enter your first name</label>
        <input type="text" id="firstname" name="firstname" required>

        <label for="lastname">Enter your last name</label>
        <input type="text" id="lastname" name="lastname" required>

        <label for="email">Enter your email</label>
        <input type="text" id="email" name="email" required>

        <label for="password">Enter your password</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Sign Up">
    </form>

</body>
</html>
