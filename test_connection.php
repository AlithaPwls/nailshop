<?php
require_once(__DIR__ . "/classes/Db.php");

try {
    $conn = Db::getConnection();
    echo "Connection successful!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
