<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once('pdo.php');

// if (isset($_GET['reset_token']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
//     $token = $_GET['reset_token'];

//     $stmt = $pdo->prepare('SELECT * FROM user WHERE reset_token = :reset_token');
//     $stmt->execute(['reset_token' => $token]);
//     $user = $stmt->fetch();

//     if ($user) {
//         $data = json_decode(file_get_contents('php://input'), true);

//         $password = $data['password'];
//         $confirmPassword = $data['confirm_password'];

//         if ($password === $confirmPassword) {
//             $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

//             $stmt = $pdo->prepare('UPDATE user SET password = :password, reset_token = NULL WHERE reset_token = :reset_token');
//             $stmt->execute([
//                 'password' => $hashedPassword,
//                 'reset_token' => $token
//             ]);

//             $response = ['success' => true];
//             echo json_encode($response);
//             exit();
//         } else {
//             $response = ['success' => false, 'message' => "Les mots de passe ne correspondent pas."];
//             echo json_encode($response);
//             exit();
//         }
//     } else {
//         $response = ['success' => false, 'message' => "Jeton de réinitialisation invalide."];
//         echo json_encode($response);
//         exit();
//     }
// } else {
//     $response = ['success' => false, 'message' => "Jeton non spécifié ou méthode de demande incorrecte."];
//     echo json_encode($response);
//     exit();
// }




header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once('pdo.php');

$response = ['success' => false, 'message' => ""];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = isset($_GET['reset_token']) ? $_GET['reset_token'] : '';

    if (!empty($token)) {
        $stmt = $pdo->prepare('SELECT * FROM user WHERE reset_token = :reset_token');
        $stmt->execute(['reset_token' => $token]);
        $user = $stmt->fetch();

        if ($user) {
            // Récupérer les données JSON envoyées dans le corps de la requête
            $data = json_decode(file_get_contents('php://input'), true);

            // Extraire les valeurs des champs 'password' et 'confirm_password' du tableau de données
            $password = $data['password'];
            $confirmPassword = $data['confirm_password'];

            // À ce stade, vous pouvez utiliser les variables $password et $confirmPassword
            // pour effectuer des opérations supplémentaires, comme la vérification de la correspondance des mots de passe, etc.
            // Notez que les valeurs des champs doivent être présentes dans le tableau $data pour que cela fonctionne correctement.

            if ($password === $confirmPassword) {
                $hashedPassword = password_hash($password, PASSWORD_ARGON2I);

                $stmt = $pdo->prepare('UPDATE user SET password = :password, reset_token = NULL WHERE reset_token = :reset_token');
                $stmt->execute([
                    'password' => $hashedPassword,
                    'reset_token' => $token
                ]);

                $response['success'] = true;
                $response['message'] = "Le mot de passe a été réinitialisé avec succès.";
            } else {
                $response['message'] = "Les mots de passe ne correspondent pas.";
            }
        } else {
            $response['message'] = "Jeton de réinitialisation invalide.";
        }
    } else {
        $response['message'] = "Jeton non spécifié.";
    }
} else {
    $response['message'] = "Méthode de demande incorrecte.";
}

echo json_encode($response);
exit();
