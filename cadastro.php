<?php
    require_once 'conexao.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Astok</title>
    <link rel="stylesheet" href="assets/css/login-cadastro.css">
</head>
<body>
    <div id="tela-de-cadastro">
        <div id="form-cadastro">
            <h1>Faça seu <br> cadastro</h1>
            <?php
                try {
                    if(isset($_POST['nome-empresa'], $_POST['cnpj'], $_POST['senha'])){
                        $nomeEmpresa = trim($_POST['nome-empresa']);
                        $cnpj = trim($_POST['cnpj']);
                        $senha = trim($_POST['senha']);
                        $senha = password_hash($senha, PASSWORD_DEFAULT);
                        if(!empty($nomeEmpresa) && !empty($cnpj) && !empty($senha)){
                            $consulta = $conexao->prepare("SELECT * FROM usuario WHERE cnpj = :verificando_cnpj");
                            $consulta->bindValue(':verificando_cnpj', $cnpj);
                            $consulta->execute();
                            $resultado = $consulta->rowCount();

                            if($resultado === 0){
                                $stmt = $conexao->prepare(query:'INSERT INTO usuario (Nome_da_empresa, cnpj, Senha) VALUES (:nome, :cnpj, :senha)');
                                $stmt->bindValue(':nome', $nomeEmpresa); 
                                $stmt->bindValue(':cnpj', $cnpj);
                                $stmt->bindValue(':senha', $senha);
                                if($stmt->execute()){
                                    if($stmt->rowCount() > 0){
                                        $id = null;
                                        $nomeEmpresa = null;
                                        $cnpj = null;
                                        $senha = null;

                                        session_start();
                                        $_SESSION['id'] = $conexao->lastInsertId();
                                        header('Location: tela-inicial.php');
                                    }else{
                                        echo "<div class='erro'>Erro ao tentar efetivar cadastro.</div>";
                                    }
                                }else{
                                    throw new PDOException("Erro: Não foi possível executar a declaração sql");
                                }
                            }else{
                                echo "<div class='erro'>CNPJ já existe no sistema.</div>";
                            }
                        }else{
                            echo "<div class='erro'>Confira se todos os dados foram preenchidos.</div>";
                        }
                    }
                }catch (PDOException $erro) {
                    echo "Erro: " . $erro->getMessage();
                }
            ?>
            <form action="" method="post">
            <label class="rotulo" for="nome-empresa">Nome da empresa:</label>
            <input type="text" name="nome-empresa" class="estilo-input" placeholder="Ex: Mecardinho Ramos">
            <label class="rotulo" for="cnpj">CNPJ:</label>
            <input type="text" name="cnpj" class="estilo-input" placeholder="Ex: 12.345.678/0001-95">
            <label class="rotulo" for="senha">Senha:</label>
            <input type="password" name="senha" class="estilo-input" placeholder="Ex: 78364724289">
            <input type="submit" value="Cadastre-se" class="botoes">
            </form>
        </div>
        <div id="imagem-lateral">
            <img id="imagem-login" src="assets/imagens/imagem-login.png" alt="">
            <img id="logo" src="assets/imagens/logo.png" alt="Logo Astok">
        </div>
    </div>
</body>
</html>