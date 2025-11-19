<?php
header('Content-Type: application/json; charset=utf-8');
require '../config/database.php';
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'not_authenticated']);
    exit;
}

$user_id = $_SESSION['id'];

$status = $_GET['status'] ?? '';
$search = trim($_GET['search'] ?? '');

$query = "SELECT * FROM tasks WHERE user_id = ?";
$params = [$user_id];

if ($status !== "") {
    $query .= " AND status = ?";
    $params[] = $status;
}

if ($search !== "") {
    $query .= " AND titulo LIKE ?";
    $params[] = "%$search%";
}

$query .= " ORDER BY data_criacao DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'success' => true,
    'tasks' => $tasks
]);
