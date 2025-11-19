<?php
// Resposta será sempre em JSON
header('Content-Type: application/json; charset=utf-8');

require '../config/database.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'not_authenticated']);
    exit;
}

// ID do usuário logado
$user_id = $_SESSION['id'];

// Filtros recebidos via GET
$status = $_GET['status'] ?? '';
$search = trim($_GET['search'] ?? '');

// Query base pegando apenas tarefas do usuário
$query = "SELECT * FROM tasks WHERE user_id = ?";
$params = [$user_id];

// Filtro por status
if ($status !== "") {
    $query .= " AND status = ?";
    $params[] = $status;
}

// Filtro por busca no título
if ($search !== "") {
    $query .= " AND titulo LIKE ?";
    $params[] = "%$search%";
}

// Ordena da tarefa mais recente para a mais antiga
$query .= " ORDER BY data_criacao DESC";

// Execução da query
$stmt = $pdo->prepare($query);
$stmt->execute($params);

// Lista final das tarefas filtradas
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retorno JSON
echo json_encode([
    'success' => true,
    'tasks' => $tasks
]);
