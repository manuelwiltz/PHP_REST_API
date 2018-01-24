<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();
$product->user_id = $user_id;

$stmt = $product->readByUser($user_id);
$num = $stmt->rowCount();

if ($num > 0) {

    $products_arr = array();
    $products_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $product_item = array(
            "id" => $id,
            "cat_name" => $cat_name,
            "cat_desc" => $cat_desc,
            "user_id" => $user_id,
            "name" => $name,
            "description" => $description,
            "price" => $price,
            "amount" => $amount,
            "created" => $created
        );

        array_push($products_arr["records"], $product_item);
    }

    echo json_encode($products_arr);
} else {
    echo json_encode(
            array("message" => "You have no products!")
    );
}

