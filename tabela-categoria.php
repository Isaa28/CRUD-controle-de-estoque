<?php

    require_once "protect.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela produtos</title>
    <link rel="stylesheet" href="assets/css/tabelas.css">
    <link rel="stylesheet" href="assets/css/menu.css">
    <script src="https://kit.fontawesome.com/2e3161fd5b.js" crossorigin="anonymous"></script>
</head>
<body>
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
    <?php
        require_once 'conexao.php';
                          
        $id_usuario = $_SESSION["id"];
        
        $dados = $conexao->prepare('SELECT * FROM categorias WHERE Usuario_ID = :id;');
        $dados->bindValue(":id", $id_usuario);
        $dados->execute();
    ?>
    <h1 id="titulo">Categorias</h1>
    <a id="cancelar-cadastrar" href="cadastro-categoria.php">Cadastrar</a>
    <div id="div-tabela">
    <?php
        if (!empty($_GET['mensagemerro'])) {
            $mensagem = htmlspecialchars($_GET['mensagemerro']);
            echo "<div class='mensagem-erro'>{$mensagem}</div>";
        }
        if (!empty($_GET['mensagemsucesso'])) {
            $mensagem = htmlspecialchars($_GET['mensagemsucesso']);
            echo "<div class='mensagem-sucesso'>{$mensagem}</div>";
        }
    ?>    
        <table id="tabela">
            <thead id="cabeca-tabela" id="cabecalho-categoria">
                <tr>
                    <th>Nome da categoria</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody id="corpodatabela">
                <?php while($rows = $dados->fetch(PDO::FETCH_OBJ)): ?>
                    <tr>
                        <td><?= htmlspecialchars($rows->Nome_categoria) ?></td>
                        <td class="acoes">
                            
                            <a class="icons" href="alterar-categoria.php?id=<?= $rows->ID ?>">
                               <i class="fa-solid fa-pen"></i>
                            </a>
                            <a class="icons" href="excluir-categoria.php?id=<?= $rows->ID ?>" onclick="return confirm('Tem certeza que deseja excluir esta categoria?Ao exclui-la todos os produtos vinculados a ela seram apagados.');">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>

        </table>
    </div>
</body>
</html>