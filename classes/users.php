<?php

include_once("Db.php");

class User {
    private $email;
    private $password;
}
    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        if(empty($email)){
            throw new Exception("Invalid email address");
        }
        $this->email = $email;

        return $this;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        if(empty($password)){
            throw new Exception("Password must be at least 8 characters long");
        }
        // Hash het wachtwoord
        $this->password = $password;

        return $this;
    }

    public function save(){
        $conn = Db::getConnection();
        $conn = new PDO('mysql:host=localhost;dbname=shop', 'root', '');
        $statement = $conn->prepare('INSERT INTO users (email, password) VALUES (:email, :password)' );
        $statement->bindValue(':email', $this->email);
        $statement->bindValue(':password', $this->password);
        $statement->execute();
    }

    public static function getAll(){
        $conn = Db::getConnection();
        $conn = new PDO ('mysql:host=localhost;dbname=shop', 'root', '');
        $statement = $conn->query('SELECT * FROM users');
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

?>
