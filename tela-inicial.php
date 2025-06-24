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
    <link rel="stylesheet" href="assets/css/menu.css">
</head>
<body>
    <div id="tela-inicial">
        <menu id="menu">
            <div id="logo">
                <img width = "110px" src="assets/imagens/logo.png" alt="Logo">
            </div>
            <div id="menu-links">
                <li><a href="tela-inicial.php">Home</a></li>
                <li><a href="#">Entradas</a></li>
                <li><a href="#">Saídas</a></li>
                <li><a href="tabela-produto.php">Produtos</a></li>
                <li><a href="tabela-fornecedor.php">Fornecedores</a></li>
                <li><a href="tabela-categoria.php">Categorias</a></li>
                <div>
                    <button id="botao-perfil">
                        <img width="40px" src="assets/imagens/icon-perfil.svg" alt="Seu perfil">
                    </button>
                </div>
            </div>
        </menu>

        <h1 id="bem-vindo">Bem-vindo!</h1>
    <?php
        require_once 'conexao.php';

        try {

            $totalProdutos = 0;
            $totalFornecedores = 0;
            $totalCategorias = 0;
 
            $stmtProdutos = $conexao->prepare("SELECT COUNT(*) AS total FROM Produtos WHERE Usuario_ID = :id");
            $stmtProdutos->bindValue(':id', $_SESSION['id']);
            $stmtProdutos->execute();
            $totalProdutos = $stmtProdutos->fetch(PDO::FETCH_ASSOC)['total'];

            $stmtFornecedores = $conexao->prepare("SELECT COUNT(*) AS total FROM fornecedor_usuario WHERE usuario_ID = :id");
            $stmtFornecedores->bindValue(':id', $_SESSION['id']);
            $stmtFornecedores->execute();
            $totalFornecedores = $stmtFornecedores->fetch(PDO::FETCH_ASSOC)['total'];

            $stmtCategorias = $conexao->prepare("SELECT COUNT(*) AS total FROM categorias WHERE Usuario_ID = :id");
            $stmtCategorias->bindValue(':id', $_SESSION['id']);
            $stmtCategorias->execute();
            $totalCategorias = $stmtCategorias->fetch(PDO::FETCH_ASSOC)['total'];

        } catch (PDOException $erro) {
            echo "Erro: " . $erro->getMessage();
        }
    ?>
        <div id="cartoes-resumo">
            <div class="total-cadastros">
                <div class="total">
                    <h1><?php echo $totalProdutos; ?></h1>
                    <h2>Produtos</h2>
                </div>
                <p class="nomes-resumo">cadastrados</p>
            </div>
            <div class="total-cadastros">
                <div class="total">
                    <h1><?php echo $totalFornecedores; ?></h1>
                    <h2>Fornecedores</h2>
                </div>
                <p class="nomes-resumo">cadastrados</p>
            </div>
            <div class="total-cadastros">
                <div class="total">
                    <h1><?php echo $totalCategorias; ?></h1>
                    <h2>Categorias</h2>
                </div>
                <p class="nomes-resumo">cadastradas</p>
            </div>
        </div>

        <h1 id="texto-cadastrar">Novo cadastro</h1>

        <div id="caixa-cadastrar">
                <button onclick="window.location.href='cadastro-fornecedor.php'" class="botao-cadastrar">
                    <h2>Fornecedor</h2>
                    <img class="imagens-cadastro" src="assets/imagens/mais-fornecedor.svg" alt="Novo fornecedor">
                </button>
                <button onclick="window.location.href='cadastro-produto.php'" class="botao-cadastrar">
                    <h2>Produto</h2>
                    <img class="imagens-cadastro" src="assets/imagens/carrinho-de-compras.svg" alt="Carrinho de compras">
                </button>
                <button onclick="window.location.href='cadastro-categoria.php'" class="botao-cadastrar">
                    <h2>Categoria</h2>
                    <img class="imagens-cadastro" src="assets/imagens/mais-categoria.svg" alt="Nova categoria">
                </button>
            </div>
        </div>
        <p>
            <a href="logout.php">Sair</a>
        </p>
    </div>
</body>
</html>