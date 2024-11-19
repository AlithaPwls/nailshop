<?php



session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$conn = new PDO('mysql:host=localhost;dbname=shop', 'root', '');
$email = $_SESSION['email'];

$statement = $conn->prepare("SELECT firstname, lastname, email FROM users WHERE email = :email");
$statement->bindValue(':email', $email);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);
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
    <p><strong>Email adress: </strong> <?php echo htmlspecialchars($user['email']); ?></p>

    <a href="change_password.php" class="change-password-btn">Change Password</a>
    <a href="orders.php" class="orders-btn">View previous orders</a>

    </body>
</html>
