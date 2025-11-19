<?php
// Resposta sempre em JSON
header('Content-Type: application/json; charset=utf-8');

require '../config/database.php';
session_start();

// Impede exclusão sem estar logado
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'not_authenticated']);
    exit;
}

try {
    // ID da tarefa enviada pelo frontend
    $id = intval($_POST['id'] ?? 0);

    // ID do usuário logado (só pode deletar o que é dele)
    $user_id = $_SESSION['id'];

    // Deleta somente se a tarefa realmente pertencer ao usuário
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);

    // Resposta de sucesso
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // Caso aconteça algum erro inesperado
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
