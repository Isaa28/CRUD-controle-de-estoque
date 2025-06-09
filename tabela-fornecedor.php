<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/tabelas.css">
    <link rel="stylesheet" href="assets/css/menu.css">
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
        $dados = $conexao->prepare('SELECT * FROM fornecedores;');
        $dados->execute();
    ?>
    <h1 id="titulo">Fornecedores</h1>
    <a id="cancelar-cadastrar" href="cadastro-fornecedor.php">Cadastrar</a>
    <div id="div-tabela">
        <table id="tabela">
            <thead id="cabeca-tabela">
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>CNPJ</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody id="corpodatabela">
                <?php while($rows = $dados->fetch(PDO::FETCH_OBJ)): ?>
                    <tr>
                        <td><?= htmlspecialchars($rows->Nome_fornecedor) ?></td>
                        <td><?= htmlspecialchars($rows->Email) ?></td>
                        <td><?= htmlspecialchars($rows->cnpj) ?></td>
                        <td><?= htmlspecialchars($rows->Telefone) ?></td>
                        <td><?= htmlspecialchars($rows->Endereco) ?></td>
                        <td class="acoes">
                            <a class="icons"><img src="assets/imagens/icon-pencil.svg" alt="Editar" href="alterar-fornecedor.php"></a>
                            <a class="icons"><img src="assets/imagens/icon-trash.svg" alt="Excluir"></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>

        </table>
    </div>
</body>
</html>