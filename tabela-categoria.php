<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/tabelas.css">
    <link rel="stylesheet" href="assets/css/menu.css">
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
    <?php
        require_once 'conexao.php';
        $dados = $conexao->prepare('SELECT * FROM categorias;');
        $dados->execute();
    ?>
    <h1>fornecedores cadastrados</h1>
    <div id="div-tabela">
        <table id="tabela">
            <head id="cabeca-tabela">
                <tr>
                    <th>Nome</th>
                </tr>
            </head>
            <body id="corpodatabela">
                <?php
                    while($rows = $dados->fetch(PDO::FETCH_OBJ)){
                        echo '<div class="linha"> <tr>'. '<th>' . $rows->Nome_categoria .'</th> <th><a class="icons"><img src="assets/imagens/icon-pencil.svg" alt=""></a></th> <th><a class="icons"><img src="assets/imagens/icon-trash.svg" alt=""></a></th> </tr> </div>';
                        echo '<br>';
                    }
                ?>
            </body>
        </table>
    </div>
</body>
</html>