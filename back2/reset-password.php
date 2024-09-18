<?php
require 'vendor/autoload.php'; // Inclure le fichier autoload.php de PHPMailer
error_reporting(E_ALL);
ini_set('display_errors', 1);




// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $data = json_decode(file_get_contents('php://input'), true);

//     if (!isset($data['email'])) {
//         // Paramètre e-mail manquant, renvoyer une réponse d'erreur
//         echo json_encode(['success' => false, 'message' => 'Paramètre e-mail manquant.']);
//         exit();
//     }

//     $email = $data['email'];

//     // Vérifier si l'e-mail existe dans la base de données
//     $stmt = $pdo->prepare('SELECT * FROM user WHERE email = :email');
//     $stmt->execute(['email' => $email]);
//     $user = $stmt->fetch();

//     if ($user) {
//         // Générer un jeton unique pour la réinitialisation du mot de passe
//         $resetToken = bin2hex(random_bytes(32));

//         // Enregistrer le jeton dans la base de données pour l'utilisateur
//         $stmt = $pdo->prepare('UPDATE user SET reset_token = :reset_token WHERE email = :email');
//         $stmt->execute([
//             'reset_token' => $resetToken,
//             'email' => $email
//         ]);

//         // Envoyer l'e-mail contenant le lien de réinitialisation au format HTML
//         $resetLink = "http://localhost/reset-password.php?token=$resetToken";

//         $mail = new PHPMailer(true);

//         try {
//             // Configuration du serveur SMTP de Gmail

//             $mail->isSMTP();
//             $mail->Host = 'smtp.office365.com';
//             $mail->SMTPAuth = true;
//             $mail->Username = 'm.bouchghel@outlook.com'; // Remplacez par votre adresse e-mail Outlook complète
//             $mail->Password = 'Messitkt591.'; // Remplacez par votre mot de passe Outlook
//             $mail->SMTPSecure = 'tls';
//             $mail->Port = 587;




//             // Destinataire et expéditeur de l'e-mail
//             $mail->setFrom('m.bouchghel@outlook.com', 'Mohamed'); // Remplacez par votre adresse e-mail et votre nom
//             $mail->addAddress($email);

//             // Contenu de l'e-mail
//             $mail->isHTML(true);
//             $mail->Subject = "Réinitialisation du mot de passe";
//             $mail->Body = "Cliquez sur le lien suivant pour réinitialiser votre mot de passe : <a href='$resetLink'>$resetLink</a>";

//             // Envoyer l'e-mail
//             $mail->send();

//             // Réponse JSON indiquant le succès de la demande
//             echo json_encode(['success' => true]);
//             exit();
//         } catch (Exception $e) {
//             // Échec de l'envoi de l'e-mail
//             echo json_encode(['success' => false, 'message' => 'Échec de l\'envoi de l\'e-mail: ' . $mail->ErrorInfo]);
//             exit();
//         }
//     } else {
//         // L'e-mail n'existe pas dans la base de données, renvoyer une réponse d'erreur
//         echo json_encode(['success' => false, 'message' => 'Adresse e-mail introuvable dans la base de données.']);
//         exit();
//     }
// }



// require_once('pdo.php');
// // Vérifier si le jeton est valide
// if (isset($_GET['reset_token'])) {
//     $token = $_GET['reset_token'];

//     // Vérifier si le jeton existe dans la base de données
//     $stmt = $pdo->prepare('SELECT * FROM user WHERE reset_token = :reset_token');
//     $stmt->execute(['reset_token' => $token]);
//     $user = $stmt->fetch();

//     if ($user) {
//         // Jeton valide, afficher le formulaire de réinitialisation du mot de passe
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $password = $_POST['password'];
//             $confirmPassword = $_POST['confirm_password'];

//             // Vérifier si les mots de passe correspondent
//             if ($password === $confirmPassword) {
//                 // Hasher le nouveau mot de passe
//                 $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

//                 // Mettre à jour le mot de passe dans la base de données
//                 $stmt = $pdo->prepare('UPDATE user SET password = :password, reset_token = NULL WHERE reset_token = :reset_token');
//                 $stmt->execute([
//                     'password' => $hashedPassword,
//                     'reset_token' => $token
//                 ]);

//                 // Envoyer une réponse JSON pour indiquer la réussite de la réinitialisation du mot de passe
//                 $response = ['success' => true];
//                 echo json_encode($response);
//                 exit();
//             } else {
//                 // Envoyer une réponse JSON avec un message d'erreur
//                 $response = ['success' => false, 'message' => "Les mots de passe ne correspondent pas."];
//                 echo json_encode($response);
//                 exit();
//             }
//         }
//     } else {
//         // Envoyer une réponse JSON avec un message d'erreur
//         $response = ['success' => false, 'message' => "Jeton de réinitialisation invalide."];
//         echo json_encode($response);
//         exit();
//     }
// } else {
//     // Envoyer une réponse JSON avec un message d'erreur
//     $response = ['success' => false, 'message' => "Jeton non spécifié."];
//     echo json_encode($response);
//     exit();
// }








require_once('pdo.php');

// Vérifier si le jeton est valide
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Vérifier si le jeton existe dans la base de données
    $stmt = $pdo->prepare('SELECT * FROM user WHERE reset_token = :reset_token');
    $stmt->execute(['reset_token' => $token]);
    $user = $stmt->fetch();

    if ($user) {
        // Jeton valide, afficher le formulaire de réinitialisation du mot de passe
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            // Vérifier si les mots de passe correspondent
            if ($password === $confirmPassword) {
                // Hasher le nouveau mot de passe
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Mettre à jour le mot de passe dans la base de données
                $stmt = $pdo->prepare('UPDATE user SET password = :password, reset_token = NULL WHERE reset_token = :reset_token');
                $stmt->execute([
                    'password' => $hashedPassword,
                    'reset_token' => $token
                ]);

                // Envoyer une réponse JSON pour indiquer la réussite de la réinitialisation du mot de passe
                $response = ['success' => true];
                echo json_encode($response);
                exit();
            } else {
                // Envoyer une réponse JSON avec un message d'erreur
                $response = ['success' => false, 'message' => "Les mots de passe ne correspondent pas."];
                echo json_encode($response);
                exit();
            }
        }
    } else {
        // Envoyer une réponse JSON avec un message d'erreur
        $response = ['success' => false, 'message' => "Jeton de réinitialisation invalide."];
        echo json_encode($response);
        exit();
    }
} else {
    // Envoyer une réponse JSON avec un message d'erreur
    $response = ['success' => false, 'message' => "Jeton non spécifié."];
    echo json_encode($response);
    exit();
}
