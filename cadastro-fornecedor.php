<?php

    require_once "protect.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de fornecedor</title>
    <link rel="stylesheet" href="assets/css/menu.css">
    <link rel="stylesheet" href="assets/css/cadastros.css">
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
    <div id="tela-cadastro">
        <div id="imagem-lateral">
            <img id="imagem-cadastro" src="assets/imagens/imagem-fornecedor.png" alt="">
        </div>
        <div id="caixa-cadastro">
            <div id="formulario">
                <h1 id="titulo">Cadastro de fornecedor</h1>
                <?php
                    require_once "conexao.php";

                    if(isset($_POST['nome-fornecedor'], $_POST['telefone'], $_POST['cnpj'], $_POST['email-de-contato'], $_POST['endereco'])){

                        $nomeFornecedor = trim($_POST['nome-fornecedor']);
                        $email = trim($_POST['email-de-contato']);
                        $telefone = trim($_POST['telefone']);
                        $cnpj = trim($_POST['cnpj']);
                        $endereco = trim($_POST['endereco']);
                        $id_usuario = $_SESSION['id'];

                        try {
                            if(!empty($nomeFornecedor) && !empty($email) && !empty($cnpj) && !empty($telefone) && !empty($endereco)){
                                $verifica = $conexao->prepare("SELECT f.ID FROM fornecedores f INNER JOIN fornecedor_usuario fu ON f.ID = fu.Fornecedor_ID WHERE fu.Usuario_ID = :usuario_id AND (f.Email = :email OR f.cnpj = :cnpj OR f.Telefone = :telefone)");
                                $verifica->bindValue(':usuario_id', $id_usuario);
                                $verifica->bindValue(':email', $email);
                                $verifica->bindValue(':cnpj', $cnpj);
                                $verifica->bindValue(':telefone', $telefone);
                                $verifica->execute();

                                if ($verifica->rowCount() > 0) {
                                    header("Location: tabela-fornecedor.php?mensagemerro=Fornecedor já cadastrado por você.");
                                    exit;
                                }else {

                                    $stmt = $conexao->prepare("INSERT INTO fornecedores (Nome_fornecedor, Email, cnpj, Telefone, Endereco) VALUES (:nome, :email, :cnpj, :telefone, :endereco)");
                                    $stmt->bindValue(':nome', $nomeFornecedor);
                                    $stmt->bindValue(':email', $email);
                                    $stmt->bindValue(':cnpj', $cnpj);
                                    $stmt->bindValue(':telefone', $telefone);
                                    $stmt->bindValue(':endereco', $endereco);
                                    $stmt->execute();

                                    $fornecedorId = $conexao->lastInsertId();
                                }

                                $stmt = $conexao->prepare("INSERT INTO fornecedor_usuario (Usuario_ID, Fornecedor_ID) VALUES (:usuario, :fornecedor)");
                                $stmt->bindValue(':usuario', $id_usuario);
                                $stmt->bindValue(':fornecedor', $fornecedorId);
                                $stmt->execute();

                                header("Location: tabela-fornecedor.php?mensagemsucesso=Fornecedor cadastrado com sucesso.");
                                exit;
                            }else{
                                echo '<div class="erro">Preencha todas as informações.</div>';
                            }
                        } catch (PDOException $e) {
                            echo "Erro ao cadastrar fornecedor: " . $e->getMessage();
                        }
                    }
                ?>
                <form action="" method="post">
                    <div class="div-linhas">
                        <div class="grupo-form linha1">
                            <label class="rotulo" for="nome-fornecedor">Nome do fornecerdor:</label>
                            <input class="caixadeentrada" type="text" id="nome-fornecedor" name="nome-fornecedor" placeholder="Ex: Alfa alimentos">
                        </div>
                        <div class="grupo-form linha2">
                            <label class="rotulo" for="telefone">telefone:</label>
                            <input class="caixadeentrada" type="text" id="telefone" name="telefone" placeholder="Ex: (11) 98765-4321">
                        </div>
                    </div>
                    <div class="div-linhas">
                        <div class="grupo-form linha2">
                            <label class="rotulo" for="cnpj">CNPJ:</label>
                            <input class="caixadeentrada" type="text" id="cnpj" name="cnpj" placeholder="Ex: 01.234.567/0001-89">
                        </div>
                        <div class="grupo-form linha1">
                            <label class="rotulo" for="email-de-contato">Email:</label>
                            <input class="caixadeentrada" type="email" id="email-de-contato" name="email-de-contato" placeholder="Ex: contato@alfasolucoes.com.br">
                        </div>
                    </div>
                    <div class="div-linhas">
                        <div class="grupo-form linha3">
                            <label class="rotulo" for="endereco">Endereço:</label>
                            <input class="caixadeentrada" type="text" id="endereco" name="endereco" placeholder="Ex: Rua das Indústrias, 1234">
                        </div>
                    </div>
                    <div id="botoes">
                        <a id="cancelar-cadastrar" href="tabela-fornecedor.php">Cancelar</a>
                        <button id="salvar" type="submit">Salvar</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>
</body>
</html>