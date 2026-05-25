-- Criar o banco de dados (opcional)
CREATE DATABASE IF NOT EXISTS gerenciador_tarefas;
USE gerenciador_tarefas;

-- Criar a tabela de tarefas com categoria como ENUM
CREATE TABLE IF NOT EXISTS tarefas (
    id INT(7) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nome_tarefa VARCHAR(255) NOT NULL,
    descricao_tarefa VARCHAR(300),
    status_tarefa ENUM('pendente', 'em_andamento', 'concluida') NOT NULL DEFAULT 'pendente',
    categoria_tarefa ENUM('Trabalho', 'Estudo', 'Casa', 'Lazer') NOT NULL,
    data_inclusao DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_conclusao DATE DEFAULT NULL
);
--Abastece o banco de dados
INSERT INTO tarefas (nome_tarefa, descricao_tarefa, status_tarefa, categoria_tarefa, data_conclusao)
VALUES 
('Apresentação de resultados', 'Preparar slides e relatório mensal', 'em_andamento', 'Trabalho', NULL),
('Revisar contrato', 'Ler cláusulas do novo contrato com fornecedor', 'pendente', 'Trabalho', NULL),
('Curso de Python', 'Assistir módulo 4 - funções e listas', 'concluida', 'Estudo', '2026-05-19'),
('Ler livro técnico', 'Clean Code - Capítulos 5 a 8', 'pendente', 'Estudo', NULL),
('Trocar lâmpada', 'Lâmpada da cozinha queimou', 'pendente', 'Casa', NULL),
('Agendar veterinário', 'Vacinação anual do cachorro', 'concluida', 'Casa', '2026-05-18'),
('Cinema com amigos', 'Filme: Missão Impossível', 'pendente', 'Lazer', NULL),
('Planejar viagem', 'Pesquisar hotéis e passagens para o feriado', 'em_andamento', 'Lazer', NULL),
('Fazer exercícios', 'Treino de 30 minutos - cardio', 'concluida', 'Lazer', '2026-05-20'),
('Revisar código do projeto', 'Corrigir bugs e melhorar performance', 'pendente', 'Trabalho', NULL);