<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/category.php';

$database = new Database();
$db = $database->getConnection();

$product = new Category($db);

$stmt = $product->readDefaultCategories();
$num = $stmt->rowCount();

if ($num > 0) {

    $categories_arr = array();
    $categories_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = array(
            "id" => $id,
            "user_id" => $user_id,
            "name" => $name,
            "description" => $description,
            "created" => $created
        );
        array_push($categories_arr["records"], $category_item);
    }

    echo json_encode($categories_arr);
} else {
    echo json_encode(
            array("message" => "No categories found.")
    );
}