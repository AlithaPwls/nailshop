<?php 

class Db {
    private static $conn = null;

    public static function getConnection(){
        // Aanroepen met Db::getConnection();
        if (self::$conn == null) {
            $pathToSSL = __DIR__ . '/CA.pem';
            $options = array(
                PDO::MYSQL_ATTR_SSL_CA => $pathToSSL,
            );

            $host = 'fvsfdvfdvfdbvfbvf';
            $db = 'shop';
            $user = 'frgfvg';
            $pass = 'Minions2001!';
            
            try {
                self::$conn = new PDO("mysql:host=$host;port=3306;dbname=$db", $user, $pass, $options);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
