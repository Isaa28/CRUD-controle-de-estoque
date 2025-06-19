<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Fornecedor</title>
    <link rel="stylesheet" href="assets/css/menu.css">
    <link rel="stylesheet" href="assets/css/cadastros.css">
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
<div id="tela-cadastro">
    <div id="imagem-lateral">
        <img id="imagem-cadastro" src="assets/imagens/imagem-fornecedor.png" alt="">
    </div>
    <div id="caixa-cadastro">
        <div id="formulario">
            <h1 id="titulo">Alterar dados da categoria</h1>
            <?php
                require_once "protect.php";
                require_once "conexao.php";

                if (!isset($_GET['id']) || empty($_GET['id'])) {
                    header('Location: tabela-categoria.php?mensagemerro=Categoria não encontrado.');
                    exit;
                }

                $id = $_GET['id'];
                try {
                    $stmt = $conexao->prepare("SELECT * FROM categorias WHERE ID = :id");
                    $stmt->bindValue(':id', $id);
                    $stmt->execute();
                    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$categoria) {
                        echo "Categoria não encontrada.";
                        exit;
                    }
                } catch (PDOException $e) {
                    echo "Erro ao buscar categoria: " . $e->getMessage();
                    exit;
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nome = trim($_POST['nome_categoria']);

                    if (empty($nome)) {
                        echo "Nome é obrigatório.";
                    } else {
                        try {

                            $consulta = $conexao->prepare("SELECT * FROM categorias WHERE Nome_categoria = :verificando_nome AND id != :id");
                            $consulta->bindValue(':verificando_nome', $nome);
                            $consulta->bindValue(':id', $id);
                            $consulta->execute();
                            $resultado = $consulta->rowCount();

                            if($resultado == 0){

                                $update = $conexao->prepare("UPDATE categorias SET Nome_categoria = :nome WHERE ID = :id");
                                $update->bindValue(':nome', $nome);
                                $update->bindValue(':id', $id);

                                if ($update->execute()) {
                                    header('Location: tabela-categoria.php?mensagemsucesso=Categoria alterar com sucesso!');
                                    exit;
                                } else {
                                    header('Location: tabela-categoria.php?mensagemerro=Erro ao tentar alterar categoria.');
                                }
                            }else{
                                echo "<div class='erro'>[ERRO] Você está tentado alterar o nome para um já existente.</div>";
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
                        <label class="rotulo" for="nome-categoria">Nome da categoria:</label>
                        <input class="caixadeentrada" type="text" placeholder="Ex: Alimentos" id="nome-categoria" name="nome_categoria"value="<?= htmlspecialchars($categoria['Nome_categoria']) ?>">
                    </div>
                </div>
                <div id="botoes">
                    <a id="cancelar-cadastrar" href="tabela-categoria.php">Cancelar</a>
                    <button id="salvar" type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>