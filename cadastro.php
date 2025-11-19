<!DOCTYPE html>
<html>
<head>
  <title>Cadastro</title>
</head>
<body>

<h2>Criar Conta</h2>

<?php
if (isset($_GET['erro']) && $_GET['erro'] == 'email') {
    echo "<p style='color:red;'>E-mail já está sendo usado.</p>";
}
?>

<form action="controllers/auth_register.php" method="POST">
  <input type="text" name="nome" placeholder="Seu nome" required><br><br>
  <input type="email" name="email" placeholder="Seu e-mail" required><br><br>
  <input type="password" name="senha" placeholder="Sua senha" required><br><br>
  <button type="submit">Cadastrar</button>
</form>

<p><a href="index.php">Voltar ao login</a></p>

</body>
</html>