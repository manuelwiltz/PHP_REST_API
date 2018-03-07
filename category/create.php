<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/category.php';

$database = new Database();
$db = $database->getConnection();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

$category->user_id = $data->user_id;
$category->name = $data->name;
$category->description = $data->description;

if ($category->create()) {
    echo '{';
    echo '"message": "Category was created."';
    echo '}';
}

else {
    echo '{';
    echo '"message": "Unable to create category."';
    echo '}';
}