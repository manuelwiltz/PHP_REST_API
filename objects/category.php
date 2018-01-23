<?php

class Category {

    // database connection and table name
    private $conn;
    private $table_name = "category";
    // object properties
    public $id;
    public $user_id;
    public $name;
    public $description;
    public $created;

    public function __construct($db) {
        $this->conn = $db;
    }
    
    function create() {

        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                user_id=:user_id, 
                name=:name, 
                description=:description, 
                created=:created";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->created = htmlspecialchars(strip_tags($this->created));

        // bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":created", $this->created);

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
                user_id=:user_id, 
                name=:name, 
                description=:description, 
                created=:created
            WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->created = htmlspecialchars(strip_tags($this->created));

        $stmt->bindParam("user_id", $this->user_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
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
    
    //http://localhost/PHP_Projects/PHP_REST_API/category/readAll.php
    public function readAll() {
        $query = "select * from " . $this->table_name;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    //http://localhost/PHP_Projects/PHP_REST_API/category/readDefaultCategories.php
    public function readDefaultCategories() {
        $query = "select * from " . $this->table_name . " where user_id is null";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    
    //http://localhost/PHP_Projects/PHP_REST_API/category/readCategoriesByUser.php?user_id=2
    public function readCategoriesByUser() {
        $query = "select * from " . $this->table_name . " where user_id = " . $this->user_id;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    //http://localhost/PHP_Projects/PHP_REST_API/category/readAllCategoriesByUser.php?user_id=2
    public function readAllCategoriesByUser() {
        $query = "select * from " . $this->table_name . " where user_id = " . $this->user_id . " or user_id is null";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

}
