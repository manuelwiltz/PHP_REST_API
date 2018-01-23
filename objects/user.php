<?php

class User {
    
    private $conn;
    private $table_name = "user";
    
    public $id;
    public $username;
    public $password;
    public $email;
    public $firstname;
    public $lastname;
    public $job;
    public $income;
    public $created;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    //http://localhost/PHP_Projects/PHP_REST_API/user/read.php
    function read() {
        $query = "select * from user";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
    
    //http://localhost/PHP_Projects/PHP_REST_API/user/readUserById.php?id=1
    function readByUser($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = " . $this->id;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
    
    function create() {

        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                username=:username, 
                password=:password, 
                email=:email, 
                firstname=:firstname,
                lastname=:lastname, 
                job=:job, 
                income=:income, 
                created=:created";

        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->job = htmlspecialchars(strip_tags($this->job));
        $this->income = htmlspecialchars(strip_tags($this->income));
        $this->created = htmlspecialchars(strip_tags($this->created));

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":job", $this->job);
        $stmt->bindParam(":income", $this->income);
        $stmt->bindParam(":created", $this->created);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    function update() {
        
        $query = "UPDATE
                " . $this->table_name . "
            SET
                username=:username, 
                password=:password, 
                email=:email, 
                firstname=:firstname,
                lastname=:lastname, 
                job=:job, 
                income=:income, 
                created=:created
            WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->job = htmlspecialchars(strip_tags($this->job));
        $this->income = htmlspecialchars(strip_tags($this->income));
        $this->created = htmlspecialchars(strip_tags($this->created));

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":job", $this->job);
        $stmt->bindParam(":income", $this->income);
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
    
}