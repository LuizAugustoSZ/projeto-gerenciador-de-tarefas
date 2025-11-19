<?php
require '../config/database.php';
session_start();

if (!isset($_POST['email'], $_POST['senha'])) {
    header('Location: ../index.php?erro=campos');
    exit;
}

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$sql->execute([$email]);
$user = $sql->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($senha, $user['senha'])) {

    $_SESSION['id'] = $user['id'];
    $_SESSION['nome'] = $user['nome'];

    header('Location: ../dashboard.php');
    exit;
}

header('Location: ../index.php?erro=1');
exit;