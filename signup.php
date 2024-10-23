<?php
session_start(); // Zorg ervoor dat je sessies gebruikt

// wacht op gebruiker
if(!empty($_POST)){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $options = [
        'cost' => 12,
    ];

    $hash = password_hash($password, PASSWORD_DEFAULT, $options); 
    $conn = new PDO('mysql:host=localhost;dbname=shop', 'root', '');

    $statement = $conn->prepare('INSERT INTO users (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)');
    $statement->bindValue(':firstname', $firstname);
    $statement->bindValue(':lastname', $lastname);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $hash);

    if($statement->execute()){
        // Als de registratie succesvol is, sla de gebruikersinformatie op in de sessie
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email; // Je kunt hier ook andere gebruikersinformatie opslaan

        // Redirect naar index.php
        header('Location: index.php');
        exit; // Zorg ervoor dat je het script stopt na de redirect
    } else {
        // Als de registratie mislukt, kun je hier een foutmelding geven
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
    <p class="done">Already signed up? <a href="login.php">Click here to login</a></p>


</body>
</html>
