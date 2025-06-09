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
                        if(isset($_POST['nome-produto'], $_POST['preco'], $_POST['cnpj'], $_POST['quantidade'], $_POST['endereco'])){
                            
                            $nome = trim($_POST['nome-produto']);
                            $quantidade = trim($_POST['quantidade']);
                            $preco = trim($_POST['preco']);
                            $cnpj = trim($_POST['cnpj']);
                            $endereco = trim($_POST['endereco']);
                            
                            if(!empty($nome) && !empty($cnpj) && !empty($quantidade) && !empty($endereco) && !empty($preco)) {
                                
                                $consulta = $conexao->prepare("SELECT * FROM usuario WHERE cnpj = :verificando_cnpj");
                                $consulta->bindValue(':verificando_cnpj', $cnpj);
                                $consulta->execute();
                                $resultado = $consulta->rowCount();

                                if($resultado === 0) {
                                    
                                    $dados = $conexao->prepare('
                                        INSERT INTO fornecedores (Nome_fornecedor, quantidade, preco, cnpj, Endereco) 
                                        VALUES (:nome, :quantidade, :preco, :cnpj, :endereco)
                                    ');
                                    $dados->bindValue(':nome', $nome); 
                                    $dados->bindValue(':quantidade', $quantidade);
                                    $dados->bindValue(':preco', $preco);
                                    $dados->bindValue(':cnpj', $cnpj);
                                    $dados->bindValue(':endereco', $endereco);
                                    
                                    if($dados->execute()) {
                                        if($dados->rowCount() > 0) {
                                            $id = null;
                                            $nome = null;
                                            $quantidade = null;
                                            $preco = null;
                                            $cnpj = null;
                                            $endereco = null;
                                        } else {
                                            echo 'Erro ao tentar efetivar cadastro';
                                        }
                                    } else {
                                        throw new PDOException("Erro: Não foi possível executar a declaração sql");
                                    }
                                } else {
                                    echo '[ERRO] CNPJ já cadastrado.';
                                }

                            } else {
                                echo '[ERRO] Dados incompletos.';
                            }
                        }
                    } catch (PDOException $erro) {
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
                            <input class="caixadeentrada" type="email" id="email-de-contato" name="email-de-contato" placeholder="Ex: fornercerdor123@gmail.com">
                        </div>
                    </div>
                    <div class="div-linhas">
                        <div class="grupo-form linha3">
                            <label class="rotulo" for="endereco">Endereço:</label>
                            <input class="caixadeentrada" type="text" id="endereco" name="endereco" placeholder="Ex: Mirão distribuidora">
                        </div>
                    </div>
                    <div id="botoes">
                        <a id="cancelar-cadastrar" href="tela-inicial.php">Cancelar</a>
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