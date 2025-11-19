<?php
session_start(); // Inicia a sessão para poder apagá-la

session_unset(); // Remove todas as variáveis da sessão
session_destroy(); // Destroi a sessão atual

// Remove o cookie da sessão no navegador
setcookie(session_name(), '', time() - 3600, '/');

// Redireciona o usuário para a página inicial
header('Location: ../index.php');
exit;
