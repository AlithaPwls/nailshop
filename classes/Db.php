<?php 

class Db {
    private static $conn = null;

    public static function getConnection(){
        //aanroepen met Db::getConnection();
        if( self::$conn == null){
            $db_url = getenv('DATABASE_URL'); // Vraag het geheim briefje van Railway
            $db_parts = parse_url($db_url);   // Splits het in stukjes
            
            $host = $db_parts['host'];
            $port = $db_parts['port'];
            $user = $db_parts['user'];
            $pass = $db_parts['pass'];
            $dbname = ltrim($db_parts['path'], '/');
            
            self::$conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
                        return self::$conn;
        }
        else {
            return self::$conn;
        }
    }
}
