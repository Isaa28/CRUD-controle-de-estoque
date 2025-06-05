CREATE DATABASE estoque; 
USE estoque;

CREATE TABLE Usuario(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nome_da_empresa VARCHAR(100) NOT NULL,
    cnpj VARCHAR(18) NOT NULL UNIQUE,
    Senha VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE Categorias (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nome_categoria VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE Fornecedores (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nome_fornecedor VARCHAR(100) NOT NULL,
    Email VARCHAR(255) UNIQUE,
    Telefone VARCHAR(15) UNIQUE,
    cnpj VARCHAR(18) NOT NULL UNIQUE,
    Endereco VARCHAR(100)
);

CREATE TABLE Produtos (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nome_produto VARCHAR(100) NOT NULL,
    Quantidade_estoque INT NOT NULL,
    Preco DECIMAL(10,2) NOT NULL,
    Fornecedor_ID INT NOT NULL,
    Categoria_ID INT NOT NULL,
    CONSTRAINT fk_produto_fornecedor
	FOREIGN KEY (Fornecedor_ID) REFERENCES Fornecedores(ID)
	ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_produto_categoria
	FOREIGN KEY (Categoria_ID) REFERENCES Categorias(ID)
	ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE Entrada (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    data DATE NOT NULL,
    Produto_ID INT NOT NULL,
    quantidade_estoque INT NOT NULL,
    FOREIGN KEY (Produto_ID) REFERENCES Produtos(ID)
);

CREATE TABLE Saida (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    data DATE NOT NULL,
    Produto_ID INT NOT NULL,
    quantidade_estoque INT NOT NULL,
    FOREIGN KEY (Produto_ID) REFERENCES Produtos(ID)
);


SELECT * FROM produtos;
SELECT * FROM fornecedores;
SELECT * FROM categorias;
