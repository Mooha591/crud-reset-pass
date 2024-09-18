<?php
require_once("./pdo.php");
$id = $_GET["id"] ?? ''; // ?? '' permet de vérifier si l'id existe
$stmt = $pdo->prepare("SELECT * FROM task WHERE user_id = :id");
$stmt->execute([
    "id" => $id
]);

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);



echo json_encode($rows);
