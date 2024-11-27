<?php

include_once("Db.php");

class User {
    private $firstname;
    private $lastname;
    private $email;
    private $password;

    // Getter en setter voor firstname
    public function getFirstname() {
        return $this->firstname;
    }

    public function setFirstname($firstname) {
        if (empty($firstname)) {
            throw new Exception("Firstname cannot be empty");
        }
        $this->firstname = $firstname;
        return $this;
    }

    // Getter en setter voor lastname
    public function getLastname() {
        return $this->lastname;
    }

    public function setLastname($lastname) {
        if (empty($lastname)) {
            throw new Exception("Lastname cannot be empty");
        }
        $this->lastname = $lastname;
        return $this;
    }

    // Getter en setter voor email
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address");
        }
        $this->email = $email;
        return $this;
    }

    // Setter voor password
    public function setPassword($password) {
        if (empty($password)) {
            throw new Exception("Password cannot be empty");
        }
        // Hash het wachtwoord
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    // Opslaan in de database
    public function save() {
        $conn = Db::getConnection();
        $statement = $conn->prepare('INSERT INTO users (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)');
        $statement->bindValue(':firstname', $this->firstname);
        $statement->bindValue(':lastname', $this->lastname);
        $statement->bindValue(':email', $this->email);
        $statement->bindValue(':password', $this->password);
        $statement->execute();
    }

    // Ophalen van alle gebruikers
    public static function getAll() {
        $conn = Db::getConnection();
        $statement = $conn->query('SELECT * FROM users');
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ophalen van een gebruiker op basis van ID
    public static function getById($id) {
        $conn = Db::getConnection();
        $stmt = $conn->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    // Bijwerken van de currency van een gebruiker
    public static function updateCurrency($userId, $newCurrency) {
        $conn = Db::getConnection();
        $statement = $conn->prepare('UPDATE users SET currency = :currency WHERE id = :id');
        $statement->bindValue(':currency', $newCurrency, PDO::PARAM_STR);
        $statement->bindValue(':id', $userId, PDO::PARAM_INT);
        return $statement->execute();
    }

    // Controleren of een e-mailadres al bestaat
    public static function emailExists($email) {
        $conn = Db::getConnection();
        $statement = $conn->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
        $statement->bindValue(':email', $email);
        $statement->execute();
        return $statement->fetchColumn() > 0;
    }

    public static function checkIfEmailExists($email)
{
    $conn = Db::getConnection();
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn() > 0; // Retourneert true als het e-mailadres al bestaat
}

public static function registerNewUser($firstname, $lastname, $email, $password)
{
    $conn = Db::getConnection();
    $stmt = $conn->prepare('INSERT INTO users (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)');
    $stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);
    $stmt->bindValue(':lastname', $lastname, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
    return $stmt->execute(); // Voert de query uit en retourneert true als het succesvol is
}



    public static function authenticate($email, $password) {
        $conn = Db::getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Retourneert gebruikersgegevens bij succesvolle login
        }
        return false; // Retourneert false als de authenticatie mislukt
    }

    public static function getUserByEmail($email)
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bindValue(1, $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getUserProfileByEmail($email)
{
    $conn = Db::getConnection();
    $stmt = $conn->prepare("SELECT firstname, lastname, email, currency FROM users WHERE email = :email");
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC); // Retourneer de gegevens van de gebruiker
}


    public static function getPasswordByEmail($email)
{
    $conn = Db::getConnection();
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = :email");
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ? $user['password'] : null; // Retourneer het wachtwoord of null als de gebruiker niet wordt gevonden
}

public static function updatePassword($email, $newPassword)
{
    $conn = Db::getConnection();
    $statement = $conn->prepare("UPDATE users SET password = :password WHERE email = :email");
    $statement->bindValue(':password', password_hash($newPassword, PASSWORD_DEFAULT), PDO::PARAM_STR);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    return $statement->execute();
}

public static function getByEmail($email)
{
    $conn = Db::getConnection();
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}



    
}
?>