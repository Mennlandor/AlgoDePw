-- Banco de dados do sistema FoodStock
CREATE DATABASE IF NOT EXISTS db_foodstock CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE db_foodstock;

CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT NULL,
    data_validade DATE NOT NULL,
    quantidade_estoque INT NOT NULL,
    imagem VARCHAR(255) NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
