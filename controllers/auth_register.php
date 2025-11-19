<?php
require '../config/database.php';

if (!isset($_POST['nome'], $_POST['email'], $_POST['senha'])) {
    header('Location: ../cadastro.php?erro=campos');
    exit;
}

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

$check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$check->execute([$email]);

if ($check->rowCount() > 0) {
    header("Location: ../cadastro.php?erro=email");
    exit;
}

$sql = $pdo->prepare("INSERT INTO users (nome, email, senha) VALUES (?, ?, ?)");
$sql->execute([$nome, $email, $senha]);

header('Location: ../index.php?cadastro=ok');
exit;