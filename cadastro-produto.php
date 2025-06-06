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
        </div>
        <div>
            <button id="botao-perfil">
            <img width="40px" src="assets/imagens/icon-perfil.svg" alt="Seu perfil">
            </button>
        </div>
    </menu>
    <div id="caixa-cadastro">
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
        <div id="formulario">
            <form action="" method="post">
                <label class="rotulo" for="nome-produto">Nome do produto:</label>
                <input class="caixadeentrada" type="text" id="nome-produto" name="nome-produto" placeholder="Ex: Mirão distribuidora">
                <br>
                <label class="rotulo" for="preco">Preço:</label>
                <input class="caixadeentrada" type="number" id="preco" name="preco" placeholder="Ex: Mirão distribuidora">
                <br>
                <label class="rotulo" for="quantidade">Quantidade:</label>
                <input class="caixadeentrada" type="number" id="quantidade" name="quantidade" placeholder="Ex: Mirão distribuidora">
                <br>
                <label class="rotulo" for="email-de-contato">Email do fornecedor:</label>
                <input class="caixadeentrada" type="email" id="email-de-contato" name="email-de-contato" placeholder="Ex: fornercerdor123@gmail.com">
                <br>
                <label class="rotulo" for="endereco">Endereço:</label>
                <input class="caixadeentrada" type="text" id="endereco" name="endereco" placeholder="Ex: Mirão distribuidora">
                <br>
                <button class="botoes" onclick="window.location.href='tela-inicial.php'" >Cancelar</button>
                <button class="botoes" type="submit">Salvar</button>
            </form>    
        </div>
    </div>
</body>
</html>