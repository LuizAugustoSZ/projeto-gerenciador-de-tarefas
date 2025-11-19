<?php
require '../config/database.php';

// Verifica se todos os campos obrigatórios foram enviados
if (!isset($_POST['nome'], $_POST['email'], $_POST['senha'])) {
    header('Location: ../cadastro.php?erro=campos');
    exit;
}

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografa a senha

// Verifica se o e-mail já existe no banco
$check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$check->execute([$email]);

if ($check->rowCount() > 0) {
    // Caso o e-mail já esteja cadastrado
    header("Location: ../cadastro.php?erro=email");
    exit;
}

// Insere o novo usuário no banco
$sql = $pdo->prepare("INSERT INTO users (nome, email, senha) VALUES (?, ?, ?)");
$sql->execute([$nome, $email, $senha]);

// Redireciona para a tela de login avisando do sucesso
header('Location: ../index.php?cadastro=ok');
exit;
