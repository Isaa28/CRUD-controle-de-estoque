<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Astok</title>
    <link rel="stylesheet" href="assets/css/login-cadastro.css">
</head>
<body>


    <div id="tela-de-login">
        <div id="login">
            <h1>Login</h1>

            <?php
            require_once "conexao.php";

            session_start();

            if (isset($_POST["cnpj"], $_POST["senha"])) {
                $cnpj = trim($_POST["cnpj"]);
                $senha = trim($_POST["senha"]);

                if (empty($cnpj)) {
                    echo "<div class='erro'>Preencha seu CNPJ </div>";
                } elseif (empty($senha)) {
                    echo "<div class='erro'>Preencha sua senha </div>";
                } else {
                    try {
                        $stmt = $conexao->prepare("SELECT * FROM usuario WHERE cnpj = :cnpj");
                        $stmt->bindValue(":cnpj", $cnpj, PDO::PARAM_STR);
                        $stmt->execute();

                        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($usuario) {
                            if (!isset($usuario["Senha"])) {
                                echo "<div class='erro'>Erro: campo 'Senha' não encontrado no banco de dados.</div>";
                                exit();
                            }

                            if (password_verify($senha, $usuario["Senha"])) {
                                $_SESSION["id"] = $usuario["ID"];
                                $_SESSION["Nome_da_empresa"] = $usuario["Nome_da_empresa"];

                                header("Location: tela-inicial.php");
                                exit();
                            } else {
                                echo "<div class='erro'>Senha ou CNPJ incorretosdfghj.</div>";
                            }
                        } else {
                            echo "<div class='erro'>Senha ou CNPJ incorretos.</div>";
                        }
                    } catch (PDOException $e) {
                        echo "Erro: " . $e->getMessage();
                    } 
                }
            }
            ?>

            <form action="" method="post">
                <label class="rotulo" for="cnpj">CNPJ:</label>
                <input type="text" name="cnpj" class="estilo-input" placeholder="Ex: 01.234.567/0001-89">
                <label class="rotulo" for="senha">Senha:</label>
                <input type="password" name="senha" class="estilo-input" placeholder="Ex: MinhaSenha123!">
                <input type="submit" value="Entrar" class="botoes">
            </form>

            <div id="div-link">
                <p>Não tem conta?<a id="link-cadastro" href="cadastro.php">Cadastre-se</a></p>  
            </div>
        </div>
                
        <div id="imagem-lateral">
            <img id="imagem-login" src="assets/imagens/imagem-login.png" alt="">
            <img id="logo" src="assets/imagens/logo.png" alt="Logo Astok">
        </div>
    </div>
</body>
</html>