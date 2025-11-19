<?php
// Resposta em JSON
header('Content-Type: application/json; charset=utf-8');

require '../config/database.php';
session_start();

// Impede acesso sem login
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'not_authenticated']);
    exit;
}

try {
    // ID da tarefa recebida
    $id = intval($_POST['id'] ?? 0);

    // ID do usuário logado (segurança)
    $user_id = $_SESSION['id'];

    // Alterna o status entre pendente e concluída
    $stmt = $pdo->prepare("
        UPDATE tasks 
        SET status = IF(status='pendente','concluida','pendente') 
        WHERE id = ? AND user_id = ?
    ");
    $stmt->execute([$id, $user_id]);

    // Retorno OK
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // Erro inesperado
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
}
