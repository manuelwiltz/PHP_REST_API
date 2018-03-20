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
                amount=:amount";

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
            
            //Subtract Product Price from current Budget.
            //FUCK THIS SHIT

            $query_help = "SELECT * FROM budget WHERE user_id = " . $this->user_id . " and NOW() between start_date and end_date";

            if ($result = $this->conn->query($query_help)) {
                if ($result->rowCount() == 1) {
                    //Fetch Result ROW
                    $row = $result->fetch(PDO::FETCH_ASSOC);

                    $id = $row["id"];
                    $user_id = $row["user_id"];
                    $amount = $row["amount"];
                    $current_amount = floatval($row["current_amount"]) - floatval($this->price);
                    $start_date = $row["start_date"];
                    $end_date = $row["end_date"];

                    //UPDATE Product
                    $query_update = "UPDATE budget SET
                            user_id=:user_id, amount=:amount, 
                            current_amount=:current_amount, start_date=:start_date, 
                            end_date=:end_date
                        WHERE
                            id = :id";

                    $stmt = $this->conn->prepare($query_update);

                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(":user_id", $user_id);
                    $stmt->bindParam(":amount", $amount);
                    $stmt->bindParam(":current_amount", floatval($current_amount));
                    $stmt->bindParam(":start_date", $start_date);
                    $stmt->bindParam(":end_date", $end_date);

                    $stmt->execute();

                }
            }
            
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
