<?php
	function canLogin($p_email, $p_password){ 
		$conn = new PDO('mysql:host=localhost;dbname=shop', 'root', '');
		$statement = $conn->prepare('SELECT * FROM users WHERE email = :email');
		$statement->bindValue(':email', $p_email);
		$statement->execute();
		

		$user = $statement->fetch(PDO::FETCH_ASSOC);
		if($user){
			$hash = $user['password'];
			if(password_verify($p_password, $hash)){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	if(!empty($_POST)){
		$email = $_POST['email'];
		$password = $_POST['password'];
		$result = canLogin($email, $password);

		if($result){
			session_start();
			$_SESSION['user_id'] = $user['id']; // Voeg de user_id toe aan de sessie

			$_SESSION['loggedin'] = true;
			$_SESSION['email'] = $email;
			$_SESSION['currency'] = $user['currency']; // Stel currency in

			header('Location: index.php');
			exit();
		} else {
			$error = true;
		}
	}
?><!DOCTYPE html>
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

