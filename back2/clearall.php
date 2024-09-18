<?php
require_once("pdo.php");

// $data =
//     json_decode(file_get_contents("php://button"), true);
// $user_id = trim(htmlentities($data["user_id"]));
// // $user_id = htmlentities($data["user_id"]);
// $sql = "DELETE FROM task WHERE user_id > 0";
// $stmt = $pdo->prepare($sql);
// $stmt->execute([]);

// echo json_encode(["success" => "task deleted"]);


//clear all 
$sql = "DELETE FROM task WHERE user_id > 0";
$stmt = $pdo->prepare($sql);
$stmt->execute([]);

echo json_encode(["success" => "task deleted"]);
