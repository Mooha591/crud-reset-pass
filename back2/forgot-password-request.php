<?php
require_once('pdo.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['email'])) {
        $email = $data['email'];

        $stmt = $pdo->prepare('SELECT * FROM user WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            $resetToken = bin2hex(random_bytes(32));

            $stmt = $pdo->prepare('UPDATE user SET reset_token = :reset_token WHERE email = :email');
            $stmt->execute([
                'reset_token' => $resetToken,
                'email' => $email
            ]);

            $resetLink = "http://localhost:3000/resetpass?token=$resetToken";
            // $resetLink = "http://example.com/reset-password.php?token=$resetToken";

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.office365.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'm.bouchghel@outlook.com'; // Remplacez par votre adresse e-mail Outlook complète
                $mail->Password = ''; // Remplacez par votre mot de passe Outlook
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('email', 'Mohamed');
                $mail->addAddress($email);



                $mail->isHTML(true);
                $mail->Subject = "Réinitialisation du mot de passe";
                $mail->Body = "Cliquez sur le lien suivant pour réinitialiser votre mot de passe : <a href='$resetLink'>$resetLink</a>";

                $mail->send();

                echo json_encode(['success' => true]);
                exit();
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Échec de l\'envoi de l\'e-mail: ' . $mail->ErrorInfo]);
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Adresse e-mail introuvable dans la base de données.']);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Paramètre e-mail manquant.']);
        exit();
    }
}
