<?php

require_once('pdo.php');

$data = json_decode(file_get_contents("php://input"));

header("Content-Type: application/json; charset=UTF-8");
$data = json_decode(file_get_contents("php://input"), true);
$user_first_name = trim(htmlspecialchars($data["first_name"]));
$user_last_name = trim(htmlspecialchars($data["last_name"]));
$user_email = trim(htmlspecialchars($data["email"]));
$password = password_hash(trim(htmlspecialchars($data["password"])), PASSWORD_ARGON2I);

// $user_first_name = $data->first_name;
// $user_last_name = $data->last_name;
// $user_email = $data->email;
// $password = $data->password;


if ($user_first_name && $user_last_name && $user_email && $password) {
    $sql = "SELECT * FROM user WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "email" => $user_email
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo json_encode(["error" => "email already exist"]);
    } else {
        $sql = "INSERT INTO user (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "first_name" => $user_first_name,
            "last_name" => $user_last_name,
            "email" => $user_email,
            "password" => $password

        ]);
        // echo json_encode($row);
        echo json_encode(["success" => "user created"]);
    }






    //email existant

    // $sql = "SELECT * FROM register WHERE email = :email";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute([
    //     "email" => $user_email
    // ]);
    // $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // // if ($row) {
    // //     echo json_encode(["error" => "email already exist"]);
    // // } else {
    // //     echo json_encode(["success" => "user created"]);
    // // }

    // echo json_encode($row);







    // $sql = "SELECT * FROM register WHERE email = :email";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute([
    //     "email" => $user_email
    // ]);

    // $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // if ($user_email === 0) {
    //     echo json_encode(["error" => "email already exist"]);
    // } else {
    //     echo json_encode(["success" => "user created"]);
    // }

    // $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // if ($row) { //
    //     echo json_encode(["error" => "email already exist"]);
    // } else {
    //     echo json_encode(["success" => "user created"]);
    // }
};










    // $sql = "SELECT * FROM register WHERE email = :email";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute([
    //     "email" => $user_email
    // ]);

    // $user = $stmt->fetch();

    // if ($user) {
    //     echo json_encode([
    //         "error" => "email already exists"
    //     ]);
    //     exit();
    // }




    // si l'email existe déjà dans notre table register on refuse l'enregistrement
    // if ($user_email === $user_email["email"]) {
    //     echo json_encode([
    //         "error" => "email already exists"
    //     ]);
    //     exit();
    // }
