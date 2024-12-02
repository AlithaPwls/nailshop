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
                    ]*/
                   "mysql:host=mysql.railway.internal;dbname=railway",
                    "root",
                    "PZDSkWNomDWQwAYoeHMmSPGVCFByPahw",
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Fouten goed weergeven
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Resultaat als associatieve array
                    ]
                );
            } catch (PDOException $e) {
                // Laat een nette foutmelding zien als de database niet werkt
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
