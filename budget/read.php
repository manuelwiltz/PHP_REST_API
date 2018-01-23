<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/budget.php';

$database = new Database();
$db = $database->getConnection();

$budget = new Budget($db);

$stmt = $budget->read();
$num = $stmt->rowCount();

if ($num > 0) {

    $budgets_arr = array();
    $budgets_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $budget_item = array(
            "id" => $id,
            "user_id" => $user_id,
            "amount" => $amount,
            "current_amount" => $current_amount,
            "start_date" => $start_date,
            "end_date" => $end_date,
        );

        array_push($budgets_arr["records"], $budget_item);
    }

    echo json_encode($budgets_arr);
} else {
    echo json_encode(
            array("message" => "No budgets found.")
    );
}