<?php
// Sempre devolve JSON
header('Content-Type: application/json; charset=utf-8');

require '../config/database.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'not_authenticated']);
    exit;
}

// Guarda o método HTTP utilizado
$method = $_SERVER['REQUEST_METHOD'];

try {
    // ID do usuário logado
    $user_id = $_SESSION['id'];

    // GET: Usado para buscar os dados da tarefa para edição
    if ($method === "GET") {

        // ID da tarefa enviada via GET
        $id = intval($_GET['id'] ?? 0);

        // Busca a tarefa pertencente ao usuário
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);

        echo json_encode([
            'success' => true,
            'task' => $stmt->fetch(PDO::FETCH_ASSOC)
        ]);
        exit;
    }

       // POST: Atualiza os dados da tarefa enviada pelo formulário
    if ($method === "POST") {

        // ID da tarefa a ser editada
        $id = intval($_POST['id'] ?? 0);

        // Título obrigatório
        $titulo = trim($_POST['titulo']);
        $descricao = trim($_POST['descricao']);
        $data_limite = !empty($_POST['data_limite']) ? $_POST['data_limite'] : null;

        if ($titulo === '') {
            throw new Exception('Título obrigatório');
        }

        // Atualiza somente se a tarefa pertence ao usuário
        $stmt = $pdo->prepare("
            UPDATE tasks 
            SET titulo=?, descricao=?, data_limite=? 
            WHERE id = ? AND user_id = ?
        ");
        $stmt->execute([$titulo, $descricao, $data_limite, $id, $user_id]);

        echo json_encode(['success' => true]);
        exit;
    }

} catch (Exception $e) {
    // Qualquer erro cai aqui
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
