1. Arquitetura Geral

O sistema segue uma estrutura MVC simplificada, utilizando apenas PHP procedural:

Controllers: processamento de regras e chamadas ao banco

Views (.php): páginas exibidas ao usuário

Config: conexão com banco de dados

Public: arquivos JS e assets

Tecnologias principais:

PHP 8+

MySQL + PDO

Bootstrap 5

jQuery (AJAX)

XAMPP

2. Banco de Dados

Estrutura SQL
CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100) NOT NULL,
email VARCHAR(120) UNIQUE NOT NULL,
senha VARCHAR(255) NOT NULL
);

CREATE TABLE tasks (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
titulo VARCHAR(255) NOT NULL,
descricao TEXT,
status ENUM('pendente','concluida') DEFAULT 'pendente',
data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
data_limite DATE,
FOREIGN KEY (user_id) REFERENCES users(id)
);

3. Conexão com o Banco – database.php
<?php
$host = "localhost";
$dbname = "projeto_tarefas";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erro ao conectar: " . $e->getMessage());
}

4. Controllers
auth_register.php

Valida email duplicado

Hash da senha via password_hash

Insere novo usuário

Redireciona para login

auth_login.php

Busca usuário pelo email

Verifica senha via password_verify

Armazena id e nome na sessão

Redireciona para dashboard

task_create.php

Cria nova tarefa ou atualiza uma existente

Sempre vinculada ao user da sessão

Retorno em JSON

task_delete.php

Verifica se a tarefa pertence ao usuário

Exclui registro

Retorno em JSON

task_toggle.php

Alterna status pendente/concluída

Retorno em JSON

task_list.php

Lista tarefas do usuário autenticado

Aceita filtros:

status

busca por título

Retorna JSON para o frontend

5. AJAX e jQuery

Arquivo: public/js/script.js

Funcionalidades:

Carregar Tarefas
$.get("controllers/task_list.php", { status, search }, function(data) {
    // atualiza lista
});

Criar/Editar Tarefa
$.post("controllers/task_create.php", formData, function(response) {
    // fecha modal e recarrega lista
});

Alternar Status
$.post("controllers/task_toggle.php", { id: taskId }, function() {
    loadTasks();
});

Excluir Tarefa
$.post("controllers/task_delete.php", { id: deleteId }, function() {
    loadTasks();
});

6. Sessões e Segurança

Todas as páginas protegidas verificam $_SESSION['id']

Senhas armazenadas com hash

PDO com prepared statements evita SQL Injection

Tarefas só podem ser manipuladas pelo dono (verificação por user_id)

7. Configuração Local
Requisitos

XAMPP (Apache e MySQL)

Projeto dentro de:

C:\xampp\htdocs\projeto-tarefas

Banco configurado com Workbench

Executar o script SQL informado no manual funcional.

Conexão

Ajustada no arquivo:

config/database.php

8. Decisões Técnicas

Uso de PDO por segurança e flexibilidade

Estrutura simples de controllers para facilitar manutenção

Uso de Bootstrap para padronizar interface

jQuery para operações assíncronas sem recarregar páginas

Não foram usados frameworks PHP devido às restrições do desafio