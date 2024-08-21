-- DROP DATABASE BIBLICONNECT; --
CREATE DATABASE bibliconnect;
USE bibliconnect;
CREATE TABLE biblioteca (
    cod_bibli INT NOT NULL PRIMARY KEY,
    biblioteca VARCHAR(50) NOT NULL
);

CREATE TABLE leitor (
    ID_leitor INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255),
    Email VARCHAR(50) NOT NULL,
    senha VARCHAR(16),
    pontos INT DEFAULT 0,
    livros_lidos INT DEFAULT 0
);


CREATE TABLE livros_lidos (
    ID_livro INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ID_leitor INT NOT NULL,
    FOREIGN KEY (ID_leitor) REFERENCES leitor(ID_leitor)
);

CREATE TABLE bibliotecario (
    ID_bibliotecario INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE artigo (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    ano DATE NOT NULL,
    arquivo mediumblob 
);

select * from artigo;



INSERT INTO artigo (titulo, autor, ano, arquivo) VALUES ('Sistema para gerenciamento de bibliotecas','3ºNDT','2024-12-31','');



CREATE TABLE computador (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(255) NOT NULL,
    data_disponibilidade DATE NOT NULL,
    horario_disponibilidade VARCHAR(255) NOT NULL
);

INSERT INTO computador (numero, data_disponibilidade, horario_disponibilidade) VALUES
('1',  '2024-07-24', '07:00 às 08:00'),
('2',  '2024-07-24', '08:00 às 09:00'),
('3',  '2024-07-24', '09:00 às 10:00');





CREATE TABLE livro (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL,
    genero VARCHAR(30) NOT NULL,
    autor VARCHAR(50) NOT NULL,
    editora VARCHAR(50) NOT NULL,
    tombo VARCHAR(50) NOT NULL,
    ano DATE NOT NULL,
	capa mediumblob not null,
    classificacao VARCHAR(50) NOT NULL,
    n_paginas VARCHAR(50) NOT NULL,
    isbn VARCHAR(50) NOT NULL,
    status ENUM('Disponível', 'Alugado') DEFAULT 'Disponível'
);
select * from livro;
INSERT INTO livro (titulo, genero, autor, editora, tombo, ano, capa, classificacao, n_paginas, isbn) VALUES ('Alice no País das Maravilhas', 'Infantil', 'Lewis Caroll', 'Editora do Brasil S/A','123','1865-07-04','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSJhJU2bYjQSMlp8AFB6SDcmBpZgV0QR2oqCA&s','L','224', '8594541759');
UPDATE livro
SET status = 'Alugado'
WHERE id = 2;

CREATE TABLE reserva_livro (
    ID_reserva INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    data_reserva DATE NOT NULL,
    data_devolucao DATE NOT NULL,
    cod_leitor INT NOT NULL,
    cod_livro INT,
    FOREIGN KEY (cod_leitor) REFERENCES leitor(ID_leitor),
    FOREIGN KEY (cod_livro) REFERENCES livro(id)
);

INSERT INTO leitor (nome, Email, senha, livros_lidos) VALUES ('Felipe', 'felipe@example.com', '124', 2);
INSERT INTO leitor (nome, Email, senha) VALUES ('Gustavo', 'gustavo@example.com', '324');
INSERT INTO leitor (nome, Email, senha) VALUES ('Rodrigo', 'rodrigo@example.com', '423');
INSERT INTO leitor (nome, Email, senha) VALUES ('Vitor', 'vitor@example.com', '435');
INSERT INTO leitor (nome, Email, senha) VALUES ('Two9', 'two9@example.com', '546');
INSERT INTO leitor (nome, Email, senha) VALUES ('Murillo', 'murillo@example.com', '765');

INSERT INTO livros_lidos (ID_leitor) VALUES (1);