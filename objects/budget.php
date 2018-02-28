<?php

class Budget {

    private $conn;
    private $table_name = "budget";
    public $id;
    public $user_id;
    public $amount;
    public $current_amount;
    public $start_date;
    public $end_date;

    public function __construct($db) {
        $this->conn = $db;
    }

    //http://localhost/PHP_Projects/PHP_REST_API/budget/read.php
    function read() {
        $query = "select * from budget";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    //http://localhost/PHP_Projects/PHP_REST_API/budget/readByUser.php?user_id=1
    function readByUser($user_id) {
        $this->user_id = (int) htmlspecialchars(strip_tags($this->user_id));

        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = " . $this->user_id;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    //http://localhost/PHP_Projects/PHP_REST_API/budget/getCurrentBudgetByUser.php?user_id=1
    function getCurrentBudgetByUser($user_id) {
        $this->user_id = (int) htmlspecialchars(strip_tags($this->user_id));

        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = " . $this->user_id . " and NOW() between start_date and end_date";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    function create() {

        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                user_id=:user_id, 
                amount=:amount, 
                current_amount=:current_amount, 
                start_date=:start_date, 
                end_date=:end_date";

        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->amount = htmlspecialchars(strip_tags($this->amount));
        $this->current_amount = htmlspecialchars(strip_tags($this->current_amount));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":current_amount", $this->current_amount);
        $stmt->bindParam(":start_date", $this->start_date);
        $stmt->bindParam(":end_date", $this->end_date);

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
                user_id=:user_id, 
                amount=:amount, 
                current_amount=:current_amount, 
                start_date=:start_date, 
                end_date=:end_date
            WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->amount = htmlspecialchars(strip_tags($this->amount));
        $this->current_amount = htmlspecialchars(strip_tags($this->current_amount));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":current_amount", $this->current_amount);
        $stmt->bindParam(":start_date", $this->start_date);
        $stmt->bindParam(":end_date", $this->end_date);

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
