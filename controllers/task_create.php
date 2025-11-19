<?php
// Retorna sempre JSON para o frontend
header('Content-Type: application/json; charset=utf-8');

require '../config/database.php';
session_start();

// Impede criação de tarefa sem login
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'not_authenticated']);
    exit;
}

try {
    // ID do usuário logado
    $user_id = $_SESSION['id'];

    // Dados enviados pelo formulário
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $data_limite = !empty($_POST['data_limite']) ? $_POST['data_limite'] : null;

    // Validação obrigatória
    if ($titulo === '') {
        throw new Exception("Título obrigatório");
    }

    // Inserção no banco
    $stmt = $pdo->prepare("
        INSERT INTO tasks (user_id, titulo, descricao, data_limite)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$user_id, $titulo, $descricao, $data_limite]);

    // Retorna sucesso com o ID da nova tarefa
    echo json_encode([
        'success' => true,
        'id' => $pdo->lastInsertId()
    ]);

} catch (Exception $e) {
    // Retorna erro com mensagem
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
