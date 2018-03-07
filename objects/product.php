<?php

class Product {

    private $conn;
    private $table_name = "product";
    public $id;
    public $cat_id;
    public $user_id;
    public $name;
    public $description;
    public $price;
    public $created;

    public function __construct($db) {
        $this->conn = $db;
    }

    //Read all products
    //http://localhost/PHP_Projects/PHP_REST_API/product/read.php
    function read() {
        $query1 = "select product.id, product.cat_id, product.user_id, product.name, category.name as 'cat_name', category.description as 'cat_desc', product.description, product.price, product.amount, product.created from product, category where product.cat_id = category.id"; 
        
        $stmt = $this->conn->prepare($query1);
        $stmt->execute();

        return $stmt;
    }

    //Read products by username
    //http://localhost/PHP_Projects/PHP_REST_API/product/readByUser.php?user_id=1
    function readByUser($user_id) {
        $this->user_id = (int)htmlspecialchars(strip_tags($this->user_id));
        
        $query1 = "select product.id, product.cat_id, product.user_id, product.name, category.name as 'cat_name', category.description as 'cat_desc', product.description, product.price, product.amount, product.created from product, category where product.cat_id = category.id and product.user_id = " . $this->user_id; 
        
        $stmt = $this->conn->prepare($query1);
        $stmt->execute();

        return $stmt;
    }

    // create product
    function create() {

        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                cat_id=:cat_id, 
                user_id=:user_id, 
                name=:name, 
                description=:description, 
                price=:price, 
                amount=:amount";/*, 
                created=:created";*/

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->cat_id = htmlspecialchars(strip_tags($this->cat_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->amount = htmlspecialchars(strip_tags($this->amount));
        //$this->created = htmlspecialchars(strip_tags($this->created));

        // bind values
        $stmt->bindParam(":cat_id", $this->cat_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":amount", $this->amount);
        //$stmt->bindParam(":created", $this->created);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // update the product
    function update() {
        
        $query = "UPDATE
                " . $this->table_name . "
            SET
                cat_id=:cat_id, 
                user_id=:user_id, 
                name=:name, 
                description=:description, 
                price=:price, 
                amount=:amount, 
                created=:created
            WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->cat_id = htmlspecialchars(strip_tags($this->cat_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->amount = htmlspecialchars(strip_tags($this->amount));
        $this->created = htmlspecialchars(strip_tags($this->created));

        $stmt->bindParam("id", $this->id);
        $stmt->bindParam("cat_id", $this->cat_id);
        $stmt->bindParam("user_id", $this->user_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":created", $this->created);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // search products
    //http://localhost/PHP_Projects/PHP_REST_API/product/searchProductByName.php?s=Kebap
    function searchProductByName($keywords) {
        $keywords = htmlspecialchars(strip_tags($keywords));
        
        $query = "SELECT * FROM " . $this->table_name . " WHERE name LIKE ? OR description LIKE ? ";

        $stmt = $this->conn->prepare($query);

        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);

        $stmt->execute();

        return $stmt;
    }

    public function count() {
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }

}

?>
