<?php

require_once('pdo.php');
// préparer la requête
// récupère les données envoyées 
$data = json_decode(file_get_contents("php://input"));
$user_email = trim(htmlspecialchars($data->email));
$password = trim(htmlspecialchars($data->password));

// on vérifie que les données sont bien envoyées
// $user_email = $data->email;


// requête pour récupérer le mdp hashé
$result = $pdo->prepare("SELECT * FROM user WHERE email = :email");
$result->execute([
    "email" => $user_email,
]);
// récupérer le résultat
$row = $result->fetch(PDO::FETCH_ASSOC);
// récupère le mdp hashé

// $email = $row['email'];
$hash = $row['password']; // récupère le mdp hashé





// echo json_encode(["pass" => $password, "hash" => $hash]);
// vérifie si le mdp est le même que celui hashé
if (password_verify($password, $hash)) {
    // echo "ok";
    // header("location: http://localhost:3000/dashboard");
    http_response_code(200);
    echo json_encode(["user_id" => $row['user_id'], "first_name" => $row['first_name'], "last_name" => $row['last_name']]);
} else {
    echo "not ok";
}




// require_once('pdo.php');

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $data = json_decode(file_get_contents("php://input"));
//     $email = trim(htmlspecialchars($data->email));

//     // Vérifier si l'e-mail existe dans la base de données
//     $stmt = $pdo->prepare('SELECT * FROM user WHERE email = :email');
//     $stmt->execute(['email' => $email]);
//     $user = $stmt->fetch();

//     if ($user) {
//         // Générer un jeton de réinitialisation
//         $resetToken = uniqid();

//         // Mettre à jour le jeton de réinitialisation dans la base de données
//         $stmt = $pdo->prepare('UPDATE user SET reset_token = :resetToken WHERE email = :email');
//         $stmt->execute([
//             'resetToken' => $resetToken,
//             'email' => $email
//         ]);

//         // Envoyer l'e-mail de réinitialisation
//         // Ici, vous pouvez utiliser votre code d'envoi d'e-mail personnalisé
//         // et inclure le lien de réinitialisation avec le jeton

//         // Exemple :
//         $resetLink = "http://example.com/reset-password.php?token=" . $resetToken;
//         $emailBody = "Bonjour, veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe : " . $resetLink;
//         // Envoyer l'e-mail à l'utilisateur avec le lien de réinitialisation

//         // Répondre avec un message de succès ou rediriger l'utilisateur vers une page de confirmation
//         echo json_encode(["message" => "Un e-mail de réinitialisation a été envoyé à votre adresse e-mail enregistrée."]);
//     } else {
//         // L'e-mail n'existe pas dans la base de données
//         echo json_encode(["error" => "L'adresse e-mail n'a pas été trouvée."]);
//     }
// }



// if ($password === $hash) {
//     echo "ok";
// } else {
//     echo "not ok";
// }


// faire la requête
// $result = $pdo->prepare("SELECT * FROM register WHERE email = :email and password = :password");
// $result->execute([
//     "email" => $user_email,
//     "password" => $password,
// ]);


// // récupérer le résultat


// // vérifier si l'email existe dans la base de données et si le mot de passe correspond
// if ($row >= 1) {
//     http_response_code(200);
//     // $password = password_verify($password, $row['password']); 

//     $output = [
//         "email" => $row['email'],
//         "first_name" => $row['first_name'],
//         "last_name" => $row['last_name'],
//         "status" => "200"
//     ];

//     echo json_encode($output);
// } else {
//     http_response_code(202); // if email or password are incorrect
//     echo json_encode(array("message" => "Email or password are incorrect"));
// }
