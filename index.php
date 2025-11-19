<?php 
session_start(); // inicia a sessão
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Login</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body { background: #f2f2f2; }
    .card { border-radius: 12px; }
  </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card p-4 shadow" style="max-width: 380px; width: 100%;">
    
    <h3 class="text-center mb-3">Entrar</h3>

    <?php 
    // verifica se existe erro na URL
    if (isset($_GET['erro'])): 
    ?>
      <div class="alert alert-danger py-2 text-center">
        E-mail ou senha inválidos!
      </div>
    <?php endif; ?>

    <!-- formulário de login -->
    <form action="controllers/auth_login.php" method="POST">
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Senha</label>
        <input type="password" name="senha" class="form-control" required>
      </div>

      <button class="btn btn-primary w-100 mt-2">Entrar</button>
    </form>

    <p class="text-center mt-3 mb-0">
      <a href="cadastro.php">Criar conta</a>
    </p>

  </div>
</div>

</body>
</html>
