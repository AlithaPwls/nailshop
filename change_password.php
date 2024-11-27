<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include_once (__DIR__ . "/classes/User.php"); // Zorg ervoor dat de juiste klasse wordt geladen

$email = $_SESSION['email'];

if (!empty($_POST)) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Haal het huidige wachtwoord uit de database via de User-klasse
    $current_password = User::getPasswordByEmail($email);

    // Controleer of het oude wachtwoord correct is
    if ($current_password && password_verify($old_password, $current_password)) {
        // Controleer of het nieuwe wachtwoord twee keer hetzelfde is
        if ($new_password === $confirm_password) {
            // Werk het wachtwoord bij via de User-klasse
            if (User::updatePassword($email, $new_password)) {
                $success = "Your password has been successfully updated!";
            } else {
                $error = "An error occurred. Please try again.";
            }
        } else {
            $error = "The new passwords do not match.";
        }
    } else {
        $error = "The old password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="css/change_password.css">
</head>
<body>
    <?php include_once('nav.inc.php'); ?>
    <h2>Change Password</h2>

    <?php if(isset($success)): ?>
        <p><?php echo htmlspecialchars($success); ?></p>
    <?php elseif(isset($error)): ?>
        <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="" method="POST" class="foremeke">
        <label for="old_password">Enter your old password</label>
        <input type="password" id="old_password" name="old_password" required>

        <label for="new_password">Enter your new password</label>
        <input type="password" id="new_password" name="new_password" required>

        <label for="confirm_password">Confirm your new password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <input type="submit" class="submit" value="Update Password">
    </form>
</body>
</html>
