
    <?php 

    class Db {
        private static $conn = null;
    
        public static function getConnection(){
            if (self::$conn === null) {
                try {
                    $host = getenv('mysql.railway.internal');
                    $dbname = getenv('railway');
                    $username = getenv('root');
                    $password = getenv('kZDyniCCbQCadmgVoHtceFKpPOKBJgYJ');
    
                    $dsn = "mysql:host=$host;dbname=$dbname";
                    self::$conn = new PDO($dsn, $username, $password, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]);
                } catch (PDOException $e) {
                    // Handle the error appropriately
                    die('Database connection failed: ' . $e->getMessage());
                }
            }
            return self::$conn;
        }
    }



 