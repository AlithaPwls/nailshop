<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include_once (__DIR__ . "/classes/User.php");

$email = $_SESSION['email'];

// Haal de gebruikersgegevens op via de User-klasse
$user = User::getUserProfileByEmail($email);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
<?php include_once('nav.inc.php'); ?>
<h2>Welcome, <?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?>!</h2>

<p>Your profile information:</p>
<p><strong>Name: </strong> <?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></p>
<p><strong>Email address: </strong> <?php echo htmlspecialchars($user['email']); ?></p>

<a href="change_password.php" class="change-password-btn">Change Password</a>
<a href="previous_orders.php" class="orders-btn">View previous orders</a>

</body>
</html>
