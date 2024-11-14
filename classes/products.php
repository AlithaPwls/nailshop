<?php

include_once("Db.php");

class Product {
    private $color_name;
    private $color_number;
    private $price;
    private $has_glitter;
    private $image_url;
    private $color_group;
    private $color_description; // Voeg deze property toe

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
        return $this->color_description;
    }

    public function setColorDescription($description)
    {
        if (empty($description)) {
            throw new Exception("Color description cannot be empty");
        }
        $this->color_description = $description;
        return $this;
    }

    // product opslaan in db
    public function save()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare('INSERT INTO products (color_name, color_number, price, has_glitter, image_url, color_group, color_description) VALUES (:color_name, :color_number, :price, :has_glitter, :image_url, :color_group, :color_description)');
        $statement->bindValue(':color_name', $this->color_name);
        $statement->bindValue(':color_number', $this->color_number);
        $statement->bindValue(':price', $this->price);
        $statement->bindValue(':has_glitter', $this->has_glitter);
        $statement->bindValue(':image_url', $this->image_url);
        $statement->bindValue(':color_group', $this->color_group);
        $statement->bindValue(':color_description', $this->color_description);
        $statement->execute();
    }

    public static function getAll()
    {
        $conn = Db::getConnection();
        $statement = $conn->query('SELECT * FROM products');
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
