<?php

    require_once "protect.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                    require_once 'conexao.php';
                    try {
                        if(isset($_POST['nome-fornecedor'], $_POST['telefone'], $_POST['cnpj'], $_POST['email-de-contato'], $_POST['endereco'])){
                            
                            $nomeFornecedor = trim($_POST['nome-fornecedor']);
                            $email = trim($_POST['email-de-contato']);
                            $telefone = trim($_POST['telefone']);
                            $cnpj = trim($_POST['cnpj']);
                            $endereco = trim($_POST['endereco']);
                            
                            if(!empty($nomeFornecedor) && !empty($cnpj) && !empty($email) && !empty($endereco) && !empty($telefone)) {
                                
                                $consulta = $conexao->prepare("SELECT * FROM usuario WHERE cnpj = :verificando_cnpj");
                                $consulta->bindValue(':verificando_cnpj', $cnpj);
                                $consulta->execute();
                                $resultado = $consulta->rowCount();

                                if($resultado === 0) {
                                    
                                    $dados = $conexao->prepare('
                                        INSERT INTO fornecedores (Nome_fornecedor, Email, Telefone, cnpj, Endereco) 
                                        VALUES (:nome, :email, :telefone, :cnpj, :endereco)
                                    ');
                                    $dados->bindValue(':nome', $nomeFornecedor); 
                                    $dados->bindValue(':email', $email);
                                    $dados->bindValue(':telefone', $telefone);
                                    $dados->bindValue(':cnpj', $cnpj);
                                    $dados->bindValue(':endereco', $endereco);
                                    
                                    if($dados->execute()) {
                                        if($dados->rowCount() > 0) {
                                            $id = null;
                                            $nomeFornecedor = null;
                                            $email = null;
                                            $telefone = null;
                                            $cnpj = null;
                                            $endereco = null;
                                        } else {
                                            echo '<div class="erro">Erro ao tentar efetivar cadastro</div>';
                                        }
                                    } else {
                                        throw new PDOException("Erro: Não foi possível executar a declaração sql");
                                    }
                                } else {
                                    echo '<div class="erro">[ERRO] CNPJ já cadastrado.</div>';
                                }

                            } else {
                                echo '<div class="erro">[ERRO] Dados incompletos.</div>';
                            }
                        }
                    } catch (PDOException $erro) {
                        echo "Erro: " . $erro->getMessage();
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
                        <a id="cancelar" href="tela-inicial.php">Cancelar</a>
                        <button id="salvar" type="submit">Salvar</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>
</body>
</html>