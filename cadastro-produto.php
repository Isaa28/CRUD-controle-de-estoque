<?php

    require_once "protect.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de produto</title>
    <link rel="stylesheet" href="assets/css/menu.css">
    <link rel="stylesheet" href="assets/css/cadastros.css">
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
    <div id="tela-cadastro">
        <div id="caixa-cadastro"> 
            <div id="formulario">
                <h1 id="titulo">Cadastro de produto</h1>
                <?php 
                    require_once 'conexao.php';
                    try {
                        if(isset($_POST['nome-produto'], $_POST['preco'], $_POST['nome-fornecedor'], $_POST['quantidade'], $_POST['categoria'])){
    
                            $nome = trim($_POST['nome-produto']);
                            $quantidade = trim($_POST['quantidade']);
                            $preco = trim($_POST['preco']);
                            $nome_fornecedor= trim($_POST['nome-fornecedor']);
                            $categoria = trim($_POST['categoria']);
                            
                            if(!empty($nome) && !empty($nome_fornecedor) && !empty($quantidade) && !empty($categoria) && !empty($preco)) {
                                
                                $consulta = $conexao->prepare("SELECT * FROM produtos WHERE Nome_produto = :verificando_produto AND Usuario_ID = :id");
                                $consulta->bindValue(':id', $_SESSION['id']);
                                $consulta->bindValue(':verificando_produto', $nome);
                                $consulta->execute();
                                $resultado = $consulta->rowCount();

                                if($resultado === 0) {
                                    
                                    $dados = $conexao->prepare('INSERT INTO produtos (Nome_produto, Quantidade_estoque, preco, Fornecedor_ID, Categoria_ID, usuario_ID) VALUES (:nome, :quantidade, :preco, :nome_fornecedor, :categoria, :id_usuario)
                                    ');
                                    $dados->bindValue(':nome', $nome); 
                                    $dados->bindValue(':quantidade', $quantidade);
                                    $dados->bindValue(':preco', $preco);
                                    $dados->bindValue(':nome_fornecedor',  $nome_fornecedor);
                                    $dados->bindValue(':categoria', $categoria);
                                    $dados->bindValue(':id_usuario', $_SESSION['id']);
                                    
                                    if($dados->execute()) {
                                        if($dados->rowCount() > 0) {
                                            $nome = null;
                                            $quantidade = null;
                                            $preco = null;
                                            $nome_fornecedor= null;
                                            $categoria = null;

                                            header("Location: tabela-produto.php?mensagemsucesso=Produto cadastrado com sucesso.");
                                        } else {
                                            header("Location: tabela-produto.php?mensagemerro=Erro ao tentar cadastrar produto .");
                                        }
                                    } else {
                                        throw new PDOException("Erro: Não foi possível executar a declaração SQL");
                                    }
                                } else {
                                   header("Location: tabela-produto.php?mensagemerro=Produto já cadastrado por você.");
                                }

                            } else {
                                echo '<div class="erro">Preencha todas as informações.</div>';
                            }
                        } else {

                        }

                        }catch (PDOException $erro) {
                            echo "Erro: " . $erro->getMessage();
                    }
                ?>
                <form action="" method="post">
                    <div class="div-linhas">
                        <div class="grupo-form linha1">
                            <label class="rotulo" for="nome-produto">Nome do produto:</label>
                            <input class="caixadeentrada" type="text" id="nome-produto" name="nome-produto" placeholder="Ex: Feijão Carioca - 1kg">
                        </div>
                        <div class="grupo-form linha2">
                            <label class="rotulo" for="preco">Preço:</label>
                            <input class="caixadeentrada" type="number" id="preco" name="preco" placeholder="Ex: 9.50">
                        </div>
                    </div>
                    <div class="div-linhas">
                        <div class="grupo-form linha2">
                            <label class="rotulo" for="quantidade">Quantidade:</label>
                            <input class="caixadeentrada" type="number" id="quantidade" name="quantidade" placeholder="Ex: 80">
                        </div>
                        <div class="grupo-form linha1">
                            <label class="rotulo" for="nome-fornecedor">Fornecedor:</label>
                            <?php
                                $stmtfor = $conexao->prepare("SELECT f.id, f.Nome_fornecedor FROM fornecedores f INNER JOIN fornecedor_usuario fu ON fu.Fornecedor_ID = f.id WHERE fu.Usuario_ID = :id_usuario");
                                $stmtfor->bindValue(':id_usuario', $_SESSION['id']);
                                $stmtfor->execute();
                                $fornecedor = $stmtfor->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <select name="nome-fornecedor" class="select-cadastro" id="fornecedor" required>
                                <option value="">Selecione o fornecedor</option>
                                <?php foreach ($fornecedor as $for): ?>
                                    <option value="<?= htmlspecialchars($for['id']) ?>"><?= htmlspecialchars($for['Nome_fornecedor']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="div-linhas">
                        <div class="grupo-form linha3">
                            <?php
                                $stmtCat = $conexao->prepare("SELECT id, Nome_categoria FROM categorias WHERE Usuario_id = :idcategoria");
                                $stmtCat->bindValue(':idcategoria', $_SESSION['id']);
                                $stmtCat->execute();
                                $categorias = $stmtCat->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <label class="rotulo" for="categoria">Categoria:</label>
                            <select class="select-cadastro" name="categoria" id="categoria" required>
                                <option value="">Selecione a categoria</option>
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?= htmlspecialchars($cat['id']) ?>"><?= htmlspecialchars($cat['Nome_categoria']) ?></option>
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
        <div id="imagem-lateral">
            <img id="imagem-cadastro" src="assets/imagens/imagem-produtos.png" alt="">
        </div>
    </div>
</body>
</html>