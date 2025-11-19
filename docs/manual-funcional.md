1. Visão Geral

Este sistema é um gerenciador de tarefas simples, onde cada usuário pode:

Criar conta

Fazer login

Criar tarefas

Alternar o status (pendente ⇄ concluída)

Visualizar apenas suas próprias tarefas

O sistema roda localmente em:

localhost/projeto-tarefas

Tecnologias utilizadas:

XAMPP (Apache + PHP + MySQL)

MySQL Workbench para visualizar e editar dados

Bootstrap 5 para o layout

PHP (procedural) + PDO para conexão segura ao banco

2. Requisitos
Software necessário

XAMPP

PHP 8+

MySQL

MySQL Workbench

Navegador moderno (Chrome, Edge, Opera, etc.)

3. Configuração do Banco de Dados

Execute no MySQL Workbench:

create database projeto_tarefas;

use projeto_tarefas;

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

select * from users;
select * from tasks;

4. Como Rodar o Sistema (Passo a Passo)
1 — Inicializar o XAMPP

Abrir o XAMPP Control Panel

Ligar Apache

Ligar MySQL

2 — Colocar o projeto na pasta correta

Coloque a pasta do sistema em:

C:\xampp\htdocs\projeto-tarefas

3 — Criar o banco

Use o MySQL Workbench e cole as queries mostradas acima.

4 — Acessar o sistema

Acesse no navegador:

http://localhost/projeto-tarefas

5. Funcionalidades
Cadastro

O usuário informa:

Nome

E-mail

Senha

O sistema verifica:

Se o e-mail já existe

Se tudo estiver correto, a conta é criada

Login

O usuário informa:

E-mail

Senha

Se estiver correto, o usuário é levado para a tela de tarefas.

Criar Tarefa

Campos:

Título

Descrição (opcional)

Data limite (opcional)

A tarefa é salva com:

Status inicial: pendente

Data de criação automática

Alternar Status

Ao clicar na tarefa:

Se estiver pendente → vira concluída

Se estiver concluída → volta para pendente

Segurança

Cada usuário visualiza apenas suas próprias tarefas

Uso de sessões PHP

Senhas criptografadas com password_hash