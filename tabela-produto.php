<?php
require_once "protect.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="assets/css/tabelas.css">
    <link rel="stylesheet" href="assets/css/menu.css">
</head>
<body>
    <menu id="menu">
        <div id="logo">
            <img width="110px" src="assets/imagens/logo.png" alt="Logo">
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

    $dados = $conexao->prepare("SELECT p.ID, p.Nome_produto, p.Quantidade_estoque, p.preco, f.Nome_fornecedor, c.Nome_categoria FROM produtos p JOIN fornecedores f ON p.Fornecedor_ID = f.id JOIN categorias c ON p.Categoria_ID = c.id
    ");
    $dados->execute();
    ?>

    <h1 id="titulo">Produtos</h1>
    <a id="cancelar-cadastrar" href="cadastro-produto.php">Cadastrar</a>
    <div id="div-tabela">
        <table id="tabela">
            <thead id="cabeca-tabela">
                <tr>
                    <th>Nome do produto</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Categoria</th>
                    <th>Fornecedor</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody id="corpodatabela">
                <?php while($rows = $dados->fetch(PDO::FETCH_OBJ)): ?>
                    <tr>
                        <td><?= htmlspecialchars($rows->Nome_produto) ?></td>
                        <td><?= htmlspecialchars($rows->Quantidade_estoque) ?></td>
                        <td>R$ <?= number_format($rows->preco, 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($rows->Nome_categoria) ?></td>
                        <td><?= htmlspecialchars($rows->Nome_fornecedor) ?></td>
                        <td class="acoes">
                            <a class="icons" href="alterar-produto.php?id=<?= $rows->ID ?>">
                                <img src="assets/imagens/icon-pencil.svg" alt="Editar">
                            </a>
                            <a class="icons" href="excluir-produto.php?id=<?= $rows->ID ?>" onclick="return confirm('Tem certeza que deseja excluir este produto?');">
                                <img src="assets/imagens/icon-trash.svg" alt="Excluir">
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>