<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$user->username = $data->username;
$user->password = $data->password;
$user->email = $data->email;
$user->firstname = $data->firstname;
$user->lastname = $data->lastname;
$user->job = $data->job;
$user->income = $data->income;
$user->created = date('Y-m-d H:i:s');


if ($user->create()) {
    echo '{';
    echo '"message": "User was created."';
    echo '}';
} else {
    echo '{';
    echo '"message": "Unable to create User."';
    echo '}';
}