<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$conn = new PDO('mysql:host=localhost;dbname=shop', 'root', '');
$email = $_SESSION['email'];

if (!empty($_POST)) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Haal het huidige wachtwoord uit de database
    $statement = $conn->prepare("SELECT password FROM users WHERE email = :email");
    $statement->bindValue(':email', $email);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Controleer of het oude wachtwoord correct is
    if (password_verify($old_password, $user['password'])) {
        // Controleer of het nieuwe wachtwoord twee keer hetzelfde is
        if ($new_password === $confirm_password) {
            // Hash het nieuwe wachtwoord en sla het op
            $options = ['cost' => 12];
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT, $options);

            $update = $conn->prepare("UPDATE users SET password = :password WHERE email = :email");
            $update->bindValue(':password', $new_hash);
            $update->bindValue(':email', $email);

            if ($update->execute()) {
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
    <h2>Change Password</h2>

    <?php if(isset($success)): ?>
        <p><?php echo htmlspecialchars($success); ?></p>
    <?php elseif(isset($error)): ?>
        <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="old_password">Enter your old password</label>
        <input type="password" id="old_password" name="old_password" required>

        <label for="new_password">Enter your new password</label>
        <input type="password" id="new_password" name="new_password" required>

        <label for="confirm_password">Confirm your new password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <input type="submit" value="Update Password">
    </form>
</body>
</html>
