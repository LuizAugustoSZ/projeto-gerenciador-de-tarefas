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

esses codigos também estão sendo citados nos outros arquivos deste docs