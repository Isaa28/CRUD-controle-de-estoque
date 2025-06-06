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
            <li><a href="#">Produtos</a></li>
            <li><a href="#">Fornecedores</a></li>
            <li><a href="#">Categorias</a></li>
            <div>
                <button id="botao-perfil">
                <img width="40px" src="assets/imagens/icon-perfil.svg" alt="Seu perfil">
                </button>
            </div>
        </div>
        </menu>
    <div id="tela-cadastro">
        <div id="imagem-lateral">
            <img id="imagem-cadastro" src="assets/imagens/imagem-categorias.png" alt="">
        </div>
        <div id="caixa-cadastro">
            <h1 id="titulo">Cadastro de categoria</h1>
        <?php
            require_once "protect.php";
            require_once "conexao.php";

            try {
                if(isset($_POST['nome-categoria'])) {
                    $nome = trim($_POST['nome-categoria']);

                    if(!empty($nome)) {
                        $dados = $conexao->prepare('INSERT INTO categorias (Nome_categoria) VALUES (:nome)');
                        $dados->bindValue(':nome', $nome); 
                        
                        if($dados->execute()) {
                            if($dados->rowCount() > 0) {
                                $id = null;
                                $nome = null;
                            } else {
                                echo 'Erro ao tentar efetivar cadastro';
                            }
                        } else {
                            echo 'Erro ao executar a query';
                        }

                    } else {
                        echo "Preencha o nome da categoria.";
                    }
                }
            } catch (PDOException $erro) {
                echo "Erro: " . $erro->getMessage();
            }
        ?>
            <div id="formulario">
                <form action="" method="post">
                    <label class="rotulo" for="nome-categoria">Nome da categoria:</label>
                    <input class="caixadeentrada" type="text" id="nome-categoria" name="nome-categoria" placeholder="Ex: Alimento">
                    <br>
                    <div id="div-botoes">
                        <button class="botoes" type="button" onclick="window.location.href='tela-inicial.php'">Cancelar</button>
                        <input type="submit" class="botoes" value="Salvar">
                    </div>
                </form>    
            </div>
        </div>
    </div>
</body>
</html>