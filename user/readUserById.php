<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$id = isset($_GET['id']) ? $_GET['id'] : die();
$user->id = $id;

$stmt = $user->readUserById($id);
$num = $stmt->rowCount();

if ($num > 0) {

    $user_arr = array();
    $user_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $user_item = array(
            "id" => $id,
            "username" => $username,
            "password" => $password,
            "email" => $email,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "job" => $job,
            "income" => $income,
            "created" => $created
        );

        array_push($user_arr["records"], $user_item);
    }

    echo json_encode($user_arr);
} else {
    echo json_encode(
            array("message" => "You have no users!")
    );
}

