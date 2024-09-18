<?php
require_once('pdo.php');
$data = json_decode(file_get_contents("php://input"));

//récupérer l'id de l'utilisateur connecté et l'insérer dans la table task

if ($data->title) {
    $sql = "INSERT INTO task(title, user_id) VALUES (:title, :user_id )  ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "title" => $data->title,
        "user_id" => $data->user_id,
    ]);
    echo json_encode(["success" => "task created", "task_id" => $pdo->lastInsertId()]); //lastInsertId() permet de récupérer l'id de la dernière tâche créée
} else {
    echo json_encode(["error" => "task not created"]);
}
