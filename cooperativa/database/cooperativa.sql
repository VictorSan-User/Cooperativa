CREATE DATABASE IF NOT EXISTS cooperativa CHARACTER SET utf8mb4;

USE cooperativa;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('produtor', 'comerciante') NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produtor_id INT NOT NULL,
    titulo VARCHAR(150),
    descricao VARCHAR(150),
    valor DECIMAL(10, 2),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    FOREIGN KEY(produtor_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS comercios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fachada VARCHAR(255),
    endereco VARCHAR(255),
    criado_por INT NOT NULL,
    foto_fachada VARCHAR(255);
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(criado_por) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS produtos_comercio(
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    comercio_id INT NOT NULL,
    vinculado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pendente', 'aceito', 'recusado') DEFAULT 'pendente';
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE,
    FOREIGN KEY (comercio_id) REFERENCES comercios(id) ON DELETE CASCADE
);

DROP DATABASE IF NOT EXISTS cooperativa

CREATE TABLE carrinhos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('aberto', 'finalizado', 'cancelado') DEFAULT 'aberto',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE carrinho_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    carrinho_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL DEFAULT 1,
    preco_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (carrinho_id) REFERENCES carrinhos(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);
