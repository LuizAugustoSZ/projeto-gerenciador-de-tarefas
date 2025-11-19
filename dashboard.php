<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: index.php?erro=login');
    exit;
}
?>

<h2>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h2>

<p>Seu ID: <?php echo $_SESSION['id']; ?></p>

<a href="controllers/logout.php">Sair</a>