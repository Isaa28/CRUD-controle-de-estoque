<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/tabelas.css">
</head>
<body>
    <?php
        require_once 'conexao.php';
        $dados = $conexao->prepare('SELECT * FROM fornecedores;');
        $dados->execute();
    ?>
    <h1>fornecedores cadastrados</h1>
    <table id="tabela">
        <head id="cabecadatabela">
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>CNPJ</th>
                <th>Telefone</th>
                <th>Endereço</th>
            </tr>
        </head>
        <body id="corpodatabela">
<?php
    while($rows = $dados->fetch(PDO::FETCH_OBJ)){
        echo '<tr>'. '<th>' . $rows->Nome_fornecedor .'</th> <th>'. $rows->Email .'</th> <th>'. $rows->cnpj .'</th> <th>'. $rows->Telefone .'</th> <th>'. $rows->Endereco . '<th><a><img src="assets/imagens/icon-pencil.svg" alt=""></a></th> <th> </th> </tr>';
        echo '<br>';
    }
?>
        </body>
    </table>
</body>
</html>