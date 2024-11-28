<?php
class Db {
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            $pathToSSL = __DIR__ . '/BaltimoreCyberTrustRoot.crt.pem';
            $options = array(
                PDO::MYSQL_ATTR_SSL_CA => $pathToSSL,
            );

            $host = 'pinkgellac.mysql.database.azure.com';
            $dbname = 'nailshop';
            $user = 'pinkgellac';
            $pass = 'Minions2001!';

            try {
                self::$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass, $options);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
?>
