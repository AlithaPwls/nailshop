<?php

include_once("Db.php");

class User {
    private $firstname;
    private $lastname;
    private $email;
    private $password;

    // Getter en setter voor firstname
    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        if (empty($firstname)) {
            throw new Exception("Firstname cannot be empty");
        }
        $this->firstname = $firstname;
        return $this;
    }

    // Getter en setter voor lastname
    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        if (empty($lastname)) {
            throw new Exception("Lastname cannot be empty");
        }
        $this->lastname = $lastname;
        return $this;
    }

    // Getter en setter voor email
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        if (empty($email)) {
            throw new Exception("Invalid email address");
        }
        $this->email = $email;
        return $this;
    }

    // Setter voor password
    public function setPassword($password)
    {
        if (empty($password)) {
            throw new Exception("Password cannot be empty");
        }
        // Hash het wachtwoord
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    // Opslaan in de database
    public function save()
    {
        // Haal de connectie op
        $conn = Db::getConnection();  // Verwijder de dubbele PDO-instantie
        $statement = $conn->prepare('INSERT INTO users (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)');
        $statement->bindValue(':firstname', $this->firstname);
        $statement->bindValue(':lastname', $this->lastname);
        $statement->bindValue(':email', $this->email);
        $statement->bindValue(':password', $this->password);
        $statement->execute();
    }

    // Ophalen van alle gebruikers
    public static function getAll()
    {
        $conn = Db::getConnection();
        $statement = $conn->query('SELECT * FROM users');
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
