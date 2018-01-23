<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/budget.php';

$database = new Database();
$db = $database->getConnection();

$budget = new Budget($db);

$data = json_decode(file_get_contents("php://input"));

$budget->id = $data->id;

$budget->user_id = $data->user_id;
$budget->amount = $data->amount;
$budget->current_amount = $data->current_amount;
$budget->start_date = $data->start_date;
$budget->end_date = $data->end_date;

if ($budget->update()) {
    echo '{';
    echo '"message": "Budget was updated."';
    echo '}';
}

else {
    echo '{';
    echo '"message": "Unable to update Budget."';
    echo '}';
}