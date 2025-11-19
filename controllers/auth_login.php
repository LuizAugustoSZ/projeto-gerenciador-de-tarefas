<?php
require '../config/database.php';
session_start();

// Verifica se os campos obrigatórios vieram do formulário
if (!isset($_POST['email'], $_POST['senha'])) {
    header('Location: ../index.php?erro=campos');
    exit;
}

$email = $_POST['email'];
$senha = $_POST['senha'];

// Busca o usuário pelo e-mail
$sql = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$sql->execute([$email]);
$user = $sql->fetch(PDO::FETCH_ASSOC);

// Se encontrou o usuário e a senha está correta
if ($user && password_verify($senha, $user['senha'])) {

    // Salva informações básicas na sessão
    $_SESSION['id'] = $user['id'];
    $_SESSION['nome'] = $user['nome'];

    // Redireciona para o dashboard
    header('Location: ../dashboard.php');
    exit;
}

// Caso falhe, volta para o login com erro
header('Location: ../index.php?erro=1');
exit;
