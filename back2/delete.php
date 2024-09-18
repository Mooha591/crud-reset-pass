
<?php
require_once("pdo.php");

$data = json_decode(file_get_contents("php://input"), true);
$user_id = htmlentities($data["user_id"]);
// $user_id = $data["user_id"]; 
$sql = "DELETE FROM task WHERE task_id = :task_id";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    "task_id" => $data["task_id"],
]);

echo json_encode(["success" => "task deleted"]);
