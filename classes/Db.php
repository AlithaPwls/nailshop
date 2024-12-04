<?php

class Db {
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            try {
                // Verbind met de database
                self::$conn = new PDO(
                 /* "mysql:host=localhost;dbname=shop", "root", "",
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Fouten goed weergeven
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Resultaat als associatieve array
                    ]$*/
                    
                   "mysql:host=mysql.railway.internal;dbname=railway",
                    "root",
                    "PZDSkWNomDWQwAYoeHMmSPGVCFByPahw",
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC 
                    ]
                );
            } catch (PDOException $e) {
                // error als database ni werkt
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
