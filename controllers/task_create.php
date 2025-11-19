<?php
header('Content-Type: application/json; charset=utf-8');
require '../config/database.php';
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'not_authenticated']);
    exit;
}

try {
    $user_id = $_SESSION['id'];
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $data_limite = !empty($_POST['data_limite']) ? $_POST['data_limite'] : null;

    if ($titulo === '') throw new Exception("Título obrigatório");

    $stmt = $pdo->prepare("INSERT INTO tasks (user_id, titulo, descricao, data_limite) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $titulo, $descricao, $data_limite]);

    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
} catch (Exception $e) {
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
}
