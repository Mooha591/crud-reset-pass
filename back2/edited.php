<?php
require_once("./pdo.php");

$data =
    json_decode(file_get_contents("php://input"), true);
// $user_title = trim(htmlentities($data["title"]));
$user_id = trim(htmlentities($data["user_id"]));
$task_id = trim(htmlentities($data["task_id"]));
$title = trim(htmlentities($data["title"]));

echo json_encode($data["title"]);


//modifier

if ($data["title"]) {
    $sql = "UPDATE task SET title = :title WHERE task_id = :task_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "title" => $data["title"],
        "task_id" => $data["task_id"],


    ]);
    echo json_encode(["success" => "task updated"]);
} else {
    echo json_encode(["error" => "task not updated"]);
}
