<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$data = json_decode(file_get_contents("php://input"));

$product->cat_id = $data->cat_id;
$product->user_id = $data->user_id;
$product->name = $data->name;
$product->description = $data->description;
$product->price = $data->price;
$product->amount = $data->amount;
$product->created = date('Y-m-d H:i:s');

if ($product->create()) {
    echo '{';
    echo '"message": "Product was created."';
    echo '}';
}

else {
    echo '{';
    echo '"message": "Unable to create product."';
    echo '}';
}