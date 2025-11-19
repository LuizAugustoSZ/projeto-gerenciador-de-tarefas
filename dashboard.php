<?php
// Inicia a sessão
session_start();

// Se não estiver logado, redireciona
if (!isset($_SESSION['id'])) header('Location: index.php?erro=login');

// Conexão com banco
require __DIR__ . '/config/database.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Dashboard - Tarefas</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Estilo para tarefas concluídas */
    .task-done { opacity: 0.7; text-decoration: line-through; }
  </style>
</head>

<body class="bg-light">

  <nav class="navbar navbar-light bg-white shadow-sm">
    <div class="container">

      <!-- Título da navbar -->
      <span class="navbar-brand mb-0 h1">Gerenciador de Tarefas</span>

      <div>
        <!-- Nome e logout -->
        <span class="me-3">Olá, <?= htmlspecialchars($_SESSION['nome']) ?></span>
        <a href="controllers/logout.php" class="btn btn-sm btn-outline-secondary">Sair</a>
      </div>

    </div>
  </nav>

  <main class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <!-- Título -->
      <h4>Minhas tarefas</h4>

      <!-- Abrir modal -->
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTask" id="btnNew">Nova tarefa</button>
    </div>

    <div class="row mb-3">

      <!-- Filtro por status -->
      <div class="col-md-4">
        <select id="filterStatus" class="form-select">
          <option value="">Todas</option>
          <option value="pendente">Pendentes</option>
          <option value="concluida">Concluídas</option>
        </select>
      </div>

      <!-- Busca -->
      <div class="col-md-4">
        <input id="search" class="form-control" placeholder="Buscar por título">
      </div>

      <!-- Info paginação -->
      <div class="col-md-4 text-end">
        <small id="infoPagination" class="text-muted"></small>
      </div>

    </div>

    <!-- Lista gerada pelo JS -->
    <div id="tasksList"></div>

    <!-- Paginação -->
    <nav>
      <ul class="pagination" id="pagination"></ul>
    </nav>

  </main>

  <!-- MODAL CRIAR/EDITAR -->
  <div class="modal fade" id="modalTask" tabindex="-1">
    <div class="modal-dialog">
      <form id="formTask" class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Nova tarefa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <!-- ID oculto -->
          <input type="hidden" name="id" id="taskId">

          <!-- Título -->
          <div class="mb-2">
            <label class="form-label">Título</label>
            <input class="form-control" name="titulo" id="taskTitulo" required>
          </div>

          <!-- Descrição -->
          <div class="mb-2">
            <label class="form-label">Descrição</label>
            <textarea class="form-control" name="descricao" id="taskDescricao"></textarea>
          </div>

          <!-- Data limite -->
          <div class="mb-2">
            <label class="form-label">Data limite</label>
            <input type="date" class="form-control" name="data_limite" id="taskData">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary" type="submit">Salvar</button>
        </div>

      </form>
    </div>
  </div>

  <!-- MODAL DELETE -->
  <div class="modal fade" id="modalDelete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Excluir Tarefa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          Tem certeza que deseja excluir esta tarefa?
          <input type="hidden" id="delete_id">
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger" id="confirmDelete">Excluir</button>
        </div>

      </div>
    </div>
  </div>

  <!-- SCRIPTS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="public/js/script.js"></script>

</body>
</html>
