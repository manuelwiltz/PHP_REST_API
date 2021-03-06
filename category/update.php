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

$category->id = $data->id;

$category->user_id = $data->user_id;
$category->name = $data->name;
$category->description = $data->description;
$category->created = date('Y-m-d H:i:s');

if ($category->update()) {
    echo '{';
    echo '"message": "Category was updated."';
    echo '}';
}

else {
    echo '{';
    echo '"message": "Unable to update category."';
    echo '}';
}