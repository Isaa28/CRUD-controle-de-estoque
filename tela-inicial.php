<?php

    require_once "protect.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/tela-inicial.css">
</head>
<body>
        <menu id="menu">
            <div id="logo">
                <img width = "130px" src="assets/imagens/logo.png" alt="Logo">
            </div>
            <div id="menu-links">
                <li><a href="tela-inicial.php">Home</a></li>
                <li><a href="#">Entradas</a></li>
                <li><a href="#">Saídas</a></li>
                <li><a href="#">Produtos</a></li>
                <li><a href="#">Fornecedores</a></li>
                <li><a href="#">Categorias</a></li>
                <div>
                    <button id="botao-perfil">
                        <img src="assets/imagens/icon-perfil.svg" alt="Seu perfil">
                    </button>
                </div>
            </div>
        </menu>
    <h1 id="bem-vindo">Bem-vindo!</h1>
    <p>O projeto ainda está em desenvolvimento, essa é apenas uma página provisória.</p>

    <div id="cartoes-resumo">
        <div class="total-cadastros">
            <h2>Produtos</h2>
            <p>cadastrados</p>
        </div>
        <div class="total-cadastros">
            <h2>Fornecedores</h2>
            <p>cadastrados</p>
        </div>
        <div class="total-cadastros">
            <h2>Categorias</h2>
            <p>cadastradas</p>
        </div>
    </div>

    <h1>Cadastrar</h1>

    <div id="caixa-cadastrar">
        <button class="botao-cadastrar">
            <h2>Fornecedor</h2>
            <img class="imagens-cadastro" src="assets/imagens/mais-fornecedor.svg" alt="Novo fornecedor">
        </button>
        <button class="botao-cadastrar">
            <h2>Produto</h2>
            <img class="imagens-cadastro" src="assets/imagens/carrinho-de-compras.svg" alt="Carrinho de compras">
        </button>
        <button class="botao-cadastrar">
            <h2>Categoria</h2>
            <img class="imagens-cadastro" src="assets/imagens/mais-categoria.svg" alt="Nova categoria">
        </button>
    </div>
    <p>
        <a href="logout.php">Sair</a>
    </p>

</body>
</html>