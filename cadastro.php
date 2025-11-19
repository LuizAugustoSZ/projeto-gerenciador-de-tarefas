<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Cadastro</title>

  <!-- // Importa o Bootstrap para estilização -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* // Estilização simples da página */
    body { background: #f2f2f2; }
    .card { border-radius: 12px; }
  </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card p-4 shadow" style="max-width: 380px; width: 100%;">

    <h3 class="text-center mb-3">Criar Conta</h3>

    <?php if (isset($_GET['erro']) && $_GET['erro'] == 'email'): ?>
      <!-- // Alerta mostrado quando o e-mail já existe -->
      <div class="alert alert-danger py-2 text-center">
        Esse e-mail já está sendo usado.
      </div>
    <?php endif; ?>

    <!-- // Formulário de cadastro que envia para o controlador -->
    <form action="controllers/auth_register.php" method="POST">

      <!-- // Campo para nome -->
      <div class="mb-3">
        <label>Nome</label>
        <input type="text" name="nome" class="form-control" required>
      </div>

      <!-- // Campo para e-mail -->
      <div class="mb-3">
        <label>E-mail</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <!-- // Campo para senha -->
      <div class="mb-3">
        <label>Senha</label>
        <input type="password" name="senha" class="form-control" required>
      </div>

      <!-- // Botão de envio -->
      <button class="btn btn-primary w-100 mt-2">Cadastrar</button>
    </form>

    <!-- // Link para tela de login -->
    <p class="text-center mt-3 mb-0">
      <a href="index.php">Já tenho conta</a>
    </p>

  </div>
</div>

</body>
</html>
