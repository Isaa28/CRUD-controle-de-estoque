<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Alterar Produto</title>
    <link rel="stylesheet" href="assets/css/menu.css">
    <link rel="stylesheet" href="assets/css/cadastros.css">
</head>
<body>
<menu id="menu">
    <div id="logo"><img width="110px" src="assets/imagens/logo.png" alt="Logo"></div>
    <div id="menu-links">
        <li><a href="tela-inicial.php">Home</a></li>
        <li><a href="#">Entradas</a></li>
        <li><a href="#">Saídas</a></li>
        <li><a href="tabela-produto.php">Produtos</a></li>
        <li><a href="tabela-fornecedor.php">Fornecedores</a></li>
        <li><a href="tabela-categoria.php">Categorias</a></li>
        <div><button id="botao-perfil"><img width="40px" src="assets/imagens/icon-perfil.svg" alt="Perfil"></button></div>
    </div>
</menu>
<div id="tela-cadastro">
    <div id="imagem-lateral">
        <img id="imagem-cadastro" src="assets/imagens/imagem-produtos.png" alt="Imagem produto">
    </div>
    <div id="caixa-cadastro">
        <div id="formulario">
            <h1 id="titulo">Alterar dados do produto</h1>
            <?php
                require_once "protect.php";
                require_once "conexao.php";

                if (!isset($_GET['id']) || empty($_GET['id'])) {
                    header('Location: tabela-produto.php?mensagemerro=Produto não encontrado.');
                    exit;
                }

                $id = $_GET['id'];

                try {
                    $stmt = $conexao->prepare("SELECT * FROM produtos WHERE ID = :id");
                    $stmt->bindValue(':id', $id);
                    $stmt->execute();
                    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$produto) {
                        header('Location: tabela-produto.php?mensagemerro=Produto não encontrado.');
                        exit;
                    }
                } catch (PDOException $e) {
                    echo "Erro ao buscar produto: " . $e->getMessage();
                    exit;
                }

                $sqlfornecedor = "SELECT id, Nome_fornecedor FROM fornecedores";
                $stmtfor = $conexao->prepare($sqlfornecedor);
                $stmtfor->execute();
                $fornecedores = $stmtfor->fetchAll(PDO::FETCH_ASSOC);

                $sqlCategorias = "SELECT id, Nome_categoria FROM categorias";
                $stmtCat = $conexao->prepare($sqlCategorias);
                $stmtCat->execute();
                $categorias = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nome = trim($_POST['nome_produto']);
                    $quantidade = trim($_POST['quantidade']);
                    $preco = trim($_POST['preco']);
                    $id_fornecedor = trim($_POST['nome_fornecedor']);
                    $id_categoria = trim($_POST['categoria']);

                    if (empty($nome) || empty($quantidade) || empty($preco) || empty($id_fornecedor) || empty($id_categoria)) {
                        echo "<div class='erro'>Todos os campos são obrigatórios.</div>";
                    } else {
                        try {
                            $update = $conexao->prepare("UPDATE produtos SET Nome_produto = :nome, Quanti
                            dade_estoque = :quantidade, Preco = :preco, Fornecedor_ID = :fornecedor, Categoria_ID = :categoria WHERE ID = :id");
                            $update->bindValue(':nome', $nome);
                            $update->bindValue(':quantidade', $quantidade);
                            $update->bindValue(':preco', $preco);
                            $update->bindValue(':fornecedor', $id_fornecedor);
                            $update->bindValue(':categoria', $id_categoria);
                            $update->bindValue(':id', $id);

                            if ($update->execute()) {
                                header('Location: tabela-produto.php?mensagemsucesso=Produto cadastrado com sucesso!.');
                                exit;
                            } else {
                                header('Location: tabela-produto.php?mensagemerro=Erro ao tentar atualizar produto.');
                            }
                        } catch (PDOException $e) {
                            $erro = "Erro: " . $e->getMessage();
                        }
                    }
                }
            ?>
            <form action="" method="post">
                <div class="div-linhas">
                    <div class="grupo-form linha1">
                        <label class="rotulo" for="nome_produto">Nome do produto:</label>
                        <input class="caixadeentrada" type="text" id="nome_produto" name="nome_produto" value="<?= htmlspecialchars($produto['Nome_produto']) ?>" placeholder="Ex: Feijão Carioca - 1kg">
                    </div>
                    <div class="grupo-form linha2">
                        <label class="rotulo" for="preco">Preço:</label>
                        <input class="caixadeentrada" type="number" id="preco" name="preco" value="<?= htmlspecialchars($produto['Preco']) ?>" step="0.01" placeholder="Ex: 9.50">
                    </div>
                </div>

                <div class="div-linhas">
                    <div class="grupo-form linha2">
                        <label class="rotulo" for="quantidade">Quantidade:</label>
                        <input class="caixadeentrada" type="number" id="quantidade" name="quantidade" value="<?= htmlspecialchars($produto['Quantidade_estoque']) ?>" placeholder="Ex: 80">
                    </div>
                    <div class="grupo-form linha1">
                        <label class="rotulo" for="nome_fornecedor">Fornecedor:</label>
                        <select name="nome_fornecedor" class="select-cadastro" id="nome_fornecedor" required>
                            <option value="">Selecione o fornecedor</option>
                            <?php foreach ($fornecedores as $for): ?>
                                <option value="<?= $for['id'] ?>" <?= $for['id'] == $produto['Fornecedor_ID'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($for['Nome_fornecedor']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="div-linhas">
                    <div class="grupo-form linha3">
                        <label class="rotulo" for="categoria">Categoria:</label>
                        <select name="categoria" class="select-cadastro" id="categoria" required>
                            <option value="">Selecione a categoria</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat['id'] ?>"
                                    <?= $cat['id'] == $produto['Categoria_ID'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['Nome_categoria']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div id="botoes">
                    <a id="cancelar-cadastrar" href="tabela-produto.php">Cancelar</a>
                    <button id="salvar" type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>