<?php
    require_once 'conexao.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Astok</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/cadastro-usuario.css">
</head>
<body>
    <div id="tela-de-cadastro">
        <div id="form-cadastro">
            <h1>Faça seu <br> cadastro</h1>
            <form action="form-cadastro.php" method="post">
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