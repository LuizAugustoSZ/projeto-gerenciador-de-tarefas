<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php if (isset($_GET['erro'])) echo "<p style='color:red;'>E-mail ou senha inválidos!</p>"; ?>

<form action="controllers/auth_login.php" method="POST">
  <input type="email" name="email" placeholder="Seu e-mail" required><br><br>
  <input type="password" name="senha" placeholder="Sua senha" required><br><br>
  <button type="submit">Entrar</button>
</form>

<p><a href="cadastro.php">Criar conta</a></p>

</body>
</html>