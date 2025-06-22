<?php

    require_once "protect.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela fornecedor</title>
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
        $dados = $conexao->prepare('SELECT * FROM fornecedor_usuario WHERE usuario_ID = :id;');
        $dados->bindValue(":id", $id_usuario);
        $dados->execute();
        $id_fornecedor = $dados->fetch(PDO::FETCH_OBJ);
    ?>
    <h1 id="titulo">Fornecedores</h1>
    <a id="cancelar-cadastrar" href="cadastro-fornecedor.php">Cadastrar</a> 
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
            <thead id="cabeca-tabela">
                <tr>
                    <th>Nome do fornecedor</th>
                    <th>Email</th>
                    <th>CNPJ</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody id="corpodatabela">
                <?php
                    $sql = "SELECT f.* FROM fornecedores f INNER JOIN fornecedor_usuario fu ON f.ID = fu.Fornecedor_ID WHERE fu.Usuario_ID = :usuario_id";
                    $stmt = $conexao->prepare($sql);
                    $stmt->bindValue(':usuario_id', $_SESSION['id']);
                    $stmt->execute();
                    $fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <?php foreach ($fornecedores as $for): ?>
                    <tr>
                        <td><?= htmlspecialchars($for['Nome_fornecedor']) ?></td>
                        <td><?= htmlspecialchars($for['Email']) ?></td>
                        <td><?= htmlspecialchars($for['cnpj']) ?></td>
                        <td><?= htmlspecialchars($for['Telefone']) ?></td>
                        <td><?= htmlspecialchars($for['Endereco']) ?></td>
                        <td class="acoes">
                            <a class="icons-pen" href="alterar-fornecedor.php?id=<?= $for['ID'] ?>">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a class="icons-trash" href="excluir-fornecedor.php?id=<?= $for['ID'] ?>" onclick="return confirm('Tem certeza que deseja excluir este fornecedor?');">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
