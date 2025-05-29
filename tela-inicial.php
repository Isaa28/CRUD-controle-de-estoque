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
                        <img src="assets/imagens/icon-perfil.svg" alt="">
                    </button>
                </div>
            </div>
        </menu>
    <h1 id="bem-vindo">Bem-vindo!</h1>
    <p>O projeto ainda está em desenvolvimento, essa é apenas uma página provisória.</p>

    <p>
        <a href="logout.php">Sair</a>
    </p>

</body>
</html>