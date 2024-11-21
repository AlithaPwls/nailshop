<?php
function canLogin($p_email, $p_password){ 
    // Maak verbinding met de database
    $conn = new PDO('mysql:host=localhost;dbname=shop', 'root', '');
    
    // Query om gebruiker op te halen met email
    $statement = $conn->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindValue(':email', $p_email);
    $statement->execute();
    
    // Verkrijg de gebruiker
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if($user){
        // Verkrijg het gehashte wachtwoord uit de database
        $hash = $user['password'];
        
        // Controleer of het wachtwoord klopt
        if(password_verify($p_password, $hash)){
            return $user; // Retourneer de gebruikersdata als inloggen succesvol is
        } else {
            return false; // Wachtwoord klopt niet
        }
    } else {
        return false; // Geen gebruiker gevonden
    }
}

if(!empty($_POST)){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Verkrijg de gebruikersdata
    $user = canLogin($email, $password);

    if($user){
        // Start de sessie
        session_start();
        
        // Sla de gegevens van de gebruiker op in de sessie
        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['currency'] = $user['currency']; 
        $_SESSION['is_admin'] = $user['is_admin']; // Sla 'is_admin' op in de sessie

        // Verwijs door naar de homepage of dashboard
        header('Location: index.php');
        exit();
    } else {
        // Foutmelding als inloggen mislukt
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Login Form</title>
</head>
<body>
    <h2>Login to discover the colors</h2>

    <?php if(isset($error)): ?>
        <div class="form__error">
            <p>Sorry, we can't log you in with that email address and password. Can you try again?</p>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="email">Email</label><br>
        <input type="text" id="email" name="email" required><br><br> 

        <label for="password">Password</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>

    <p class="done">No account? <a href="signup.php">Click here to sign up</a></p>
</body>
</html>
