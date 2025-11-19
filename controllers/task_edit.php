<?php
header('Content-Type: application/json; charset=utf-8');
require '../config/database.php';
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'not_authenticated']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

try {
    $user_id = $_SESSION['id'];

    // PEGAR TAREFA
    if ($method === "GET") {
        $id = intval($_GET['id'] ?? 0);

        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);

        echo json_encode([
            'success' => true,
            'task' => $stmt->fetch(PDO::FETCH_ASSOC)
        ]);
        exit;
    }

    // ATUALIZAR TAREFA
    if ($method === "POST") {
        $id = intval($_POST['id'] ?? 0);
        $titulo = trim($_POST['titulo']);
        $descricao = trim($_POST['descricao']);
        $data_limite = !empty($_POST['data_limite']) ? $_POST['data_limite'] : null;

        if ($titulo === '') throw new Exception('Título obrigatório');

        $stmt = $pdo->prepare("UPDATE tasks SET titulo=?, descricao=?, data_limite=? WHERE id = ? AND user_id = ?");
        $stmt->execute([$titulo, $descricao, $data_limite, $id, $user_id]);

        echo json_encode(['success' => true]);
        exit;
    }

} catch (Exception $e) {
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
}
