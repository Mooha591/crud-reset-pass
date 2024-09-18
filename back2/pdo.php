<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header('content-type: text/html; charset=utf-8');
header("Access-Control-Max-Age: 3600");



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reactlogin";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connexion échouée: " . $e->getMessage();
    die(); // Arrêter l'exécution du script en cas d'erreur de connexion
}
