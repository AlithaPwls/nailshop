<?php
include_once("Db.php");

class Product {
    private $id;
    private $color_name;
    private $color_number;
    private $price;
    private $has_glitter;
    private $image_url;
    private $color_group;
    private $description;

    // Getters en setters voor alle velden

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid product ID");
        }
        $this->id = $id;
        return $this;
    }

    public function getColorName()
    {
        return $this->color_name;
    }

    public function setColorName($color_name)
    {
        if (empty($color_name)) {
            throw new Exception("Color name cannot be empty");
        }
        $this->color_name = $color_name;
        return $this;
    }

    public function getColorNumber()
    {
        return $this->color_number;
    }

    public function setColorNumber($color_number)
    {
        if (empty($color_number)) {
            throw new Exception("Color number cannot be empty");
        }
        $this->color_number = $color_number;
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        if (!is_numeric($price) || $price < 0) {
            throw new Exception("Price must be a non-negative number");
        }
        $this->price = $price;
        return $this;
    }

    public function getHasGlitter()
    {
        return $this->has_glitter;
    }

    public function setHasGlitter($has_glitter)
    {
        $this->has_glitter = $has_glitter ? 1 : 0;
        return $this;
    }

    public function getImageUrl()
    {
        return $this->image_url;
    }

    public function setImageUrl($image_url)
    {
        if (empty($image_url)) {
            throw new Exception("Image URL cannot be empty");
        }
        $this->image_url = $image_url;
        return $this;
    }

    public function getColorGroup()
    {
        return $this->color_group;
    }

    public function setColorGroup($color_group)
    {
        if (empty($color_group)) {
            throw new Exception("Color group cannot be empty");
        }
        $this->color_group = $color_group;
        return $this;
    }

    public function getColorDescription()
    {
        return $this->description;
    }

    public function setColorDescription($description)
    {
        if (empty($description)) {
            throw new Exception("Color description cannot be empty");
        }
        $this->description = $description;
        return $this;
    }

    // Haal een product op basis van ID
    public static function getById($id)
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bindValue(1, $id, PDO::PARAM_INT);  // Gebruik bindValue() in plaats van bind_param()
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update een bestaand product in de database
    public function update()
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare("UPDATE products SET color_name = ?, color_number = ?, price = ?, has_glitter = ?, image_url = ?, color_group = ?, description = ? WHERE id = ?");
        $stmt->bindValue(1, $this->color_name, PDO::PARAM_STR);
        $stmt->bindValue(2, $this->color_number, PDO::PARAM_STR);
        $stmt->bindValue(3, $this->price, PDO::PARAM_STR);
        $stmt->bindValue(4, $this->has_glitter, PDO::PARAM_INT);
        $stmt->bindValue(5, $this->image_url, PDO::PARAM_STR);
        $stmt->bindValue(6, $this->color_group, PDO::PARAM_STR);
        $stmt->bindValue(7, $this->description, PDO::PARAM_STR);
        $stmt->bindValue(8, $this->id, PDO::PARAM_INT);  // Bind de ID als laatste parameter
    
        return $stmt->execute();
    }
    

    // Verwijder een product op basis van ID
    public static function delete($id)
    {
        $conn = Db::getConnection();
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bindValue(1, $id, PDO::PARAM_INT);  // Gebruik bindValue() voor PDO
        return $stmt->execute();
    }

    public static function searchProducts($search_query)
{
    $conn = Db::getConnection();
    $sql = "SELECT * FROM products WHERE color_name LIKE :search_term OR color_number LIKE :search_term";
    $stmt = $conn->prepare($sql);
    $search_term = '%' . $search_query . '%';
    $stmt->bindValue(':search_term', $search_term, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourneer de zoekresultaten
}

    
    // Haal alle producten op uit de database
    public static function getAll()
    {
        $conn = Db::getConnection();
        $stmt = $conn->query("SELECT * FROM products");
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }

    // Opslaan van een nieuw product in de database
    public function save()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare('
            INSERT INTO products 
            (color_name, color_number, price, has_glitter, image_url, color_group, description) 
            VALUES 
            (:color_name, :color_number, :price, :has_glitter, :image_url, :color_group, :description)
        ');
    
        // Vervang bind_param() door bindValue()
        $statement->bindValue(':color_name', $this->color_name);
        $statement->bindValue(':color_number', $this->color_number);
        $statement->bindValue(':price', $this->price);
        $statement->bindValue(':has_glitter', $this->has_glitter);
        $statement->bindValue(':image_url', $this->image_url);
        $statement->bindValue(':color_group', $this->color_group);
        $statement->bindValue(':description', $this->description);
    
        $statement->execute();
    }

    
}
?>
