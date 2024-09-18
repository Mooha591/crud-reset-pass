<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type");

require_once('pdo.php');

$response = ['success' => false, 'message' => ""];

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $user_id = isset($data['user_id']) ? $data['user_id'] : '';
    $task_id = isset($data['task_id']) ? $data['task_id'] : '';
    $priority = isset($data['priority']) ? $data['priority'] : '';

    if (!empty($user_id) && !empty($task_id) && !empty($priority)) {
        if ($pdo) {
            $stmt = $pdo->prepare('UPDATE tasks SET priority = :priority WHERE user_id = :user_id AND task_id = :task_id');
            $stmt->execute([
                'priority' => $priority,
                'user_id' => $user_id,
                'task_id' => $task_id
            ]);

            $response['success'] = true;
            $response['message'] = "Priorité de la tâche mise à jour avec succès.";
        } else {
            $response['message'] = "Erreur de connexion à la base de données.";
        }
    } else {
        $response['message'] = "Données manquantes ou incorrectes.";
    }
} else {
    $response['message'] = "Méthode de demande incorrecte.";
}

echo json_encode($response);
exit();
