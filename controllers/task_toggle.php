<?php
header('Content-Type: application/json; charset=utf-8');
require '../config/database.php';
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'not_authenticated']);
    exit;
}

try {
    $id = intval($_POST['id'] ?? 0);
    $user_id = $_SESSION['id'];

    $stmt = $pdo->prepare("UPDATE tasks SET status = IF(status='pendente','concluida','pendente') WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
}
