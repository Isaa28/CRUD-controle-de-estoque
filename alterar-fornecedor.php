<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Fornecedor</title>
    <link rel="stylesheet" href="assets/css/menu.css">
    <link rel="stylesheet" href="assets/css/cadastros.css">
</head>
<body>
<menu id="menu">
    <div id="logo">
        <img width="110px" src="assets/imagens/logo.png" alt="Logo">
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
            <h1 id="titulo">Alterar dados do fornecedor</h1>
            <?php
                require_once "protect.php";
                require_once "conexao.php";

                if (!isset($_GET['id']) || empty($_GET['id'])) {
                    header('Location: tabela-fornecedor.php?mensagemerro=Fornecedor não encontrado.');
                    exit;
                }

                $id = $_GET['id'];
                try {
                    $stmt = $conexao->prepare("SELECT * FROM fornecedores WHERE id = :id");
                    $stmt->bindValue(':id', $id);
                    $stmt->execute();
                    $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$fornecedor) {
                        header("Location:tabela-fornecedor.php?mensagemerro=Fornecedor não encontrado.");
                        exit;
                    }
                } catch (PDOException $e) {
                    echo "Erro ao buscar fornecedor: " . $e->getMessage();
                    exit;
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nome = trim($_POST['nome_fornecedor']);
                    $email = trim($_POST['email']);
                    $cnpj = trim($_POST['cnpj']);
                    $telefone = trim($_POST['telefone']);
                    $endereco = trim($_POST['endereco']);

                    if (empty($nome) || empty($email) || empty($cnpj) || empty($telefone) || empty($endereco)) {

                        echo "<div class='erro'>Todos os campos são obrigatórios.</div>";

                    } else {
                        try {

                            $consulta = $conexao->prepare("SELECT * FROM fornecedores WHERE cnpj = :verificando_cnpj AND id != :id");
                            $consulta2 = $conexao->prepare("SELECT * FROM fornecedores WHERE Email = :verificando_email AND id != :id");
                            $consulta3 = $conexao->prepare("SELECT * FROM fornecedores WHERE Telefone = :verificando_telefone AND id != :id");
                            $consulta->bindValue(':verificando_cnpj', $cnpj);
                            $consulta->bindValue(':id', $id);
                            $consulta2->bindValue(':verificando_email', $email);
                            $consulta2->bindValue(':id', $id);
                            $consulta3->bindValue(':verificando_telefone', $telefone);
                            $consulta3->bindValue(':id', $id);

                            $consulta->execute();
                            $consulta2->execute();
                            $consulta3->execute();
                            $resultado = $consulta->rowCount();
                            $resultado2 = $consulta2->rowCount();
                            $resultado3 = $consulta3->rowCount();

                            if($resultado == 0){
                                if($resultado2 == 0){
                                    if($resultado3 == 0){

                                        $update = $conexao->prepare("UPDATE fornecedores SET Nome_fornecedor = :nome, Email = :email, cnpj = :cnpj, Telefone = :telefone, Endereco = :endereco WHERE id = :id");
                                        $update->bindValue(':nome', $nome);
                                        $update->bindValue(':email', $email);
                                        $update->bindValue(':cnpj', $cnpj);
                                        $update->bindValue(':telefone', $telefone);
                                        $update->bindValue(':endereco', $endereco);
                                        $update->bindValue(':id', $id);

                                        if ($update->execute()) {
                                            header('Location: tabela-fornecedor.php?mensagemsucesso=Fornecedor atualizado com sucesso!');
                                            exit;
                                        } else {
                                            header('Location: tabela-fornecedor.php?mensagemerro=Erro ao tentar atualizar fornecedor.');
                                        }
                                    }else{
                                        echo "<div class='erro'>[ERRO] Você está tentado alterar o telefone para um já existente.</div>";
                                    }
                                }else{
                                    echo "<div class='erro'>[ERRO] Você está tentado alterar o email para um já existente.</div>";
                                }
                            }else{
                                echo "<div class='erro'>[ERRO] Você está tentado alterar o cnpj para um já existente.</div>";
                            }
                            
                        } catch (PDOException $e) {
                            $erro = "Erro: " . $e->getMessage();
                        }
                    }
                }
            ?>
            <form action="" method="post">
                <div class="div-linhas">
                    <div class="grupo-form linha1">
                        <label class="rotulo" for="nome-fornecedor">Nome do fornecedor:</label>
                        <input class="caixadeentrada" type="text" id="nome-fornecedor" name="nome_fornecedor" value="<?= htmlspecialchars($fornecedor['Nome_fornecedor']) ?>" placeholder="Ex: Alfa alimentos">
                    </div>
                    <div class="grupo-form linha2">
                        <label class="rotulo" for="telefone">Telefone:</label>
                        <input class="caixadeentrada" type="text" id="telefone" name="telefone" value="<?= htmlspecialchars($fornecedor['Telefone']) ?>" placeholder="Ex: (11) 98765-4321">
                    </div>
                </div>
                <div class="div-linhas">
                    <div class="grupo-form linha2">
                        <label class="rotulo" for="cnpj">CNPJ:</label>
                        <input class="caixadeentrada" type="text" id="cnpj" name="cnpj" value="<?= htmlspecialchars($fornecedor['cnpj']) ?>" placeholder="Ex: 01.234.567/0001-89">
                    </div>
                    <div class="grupo-form linha1">
                        <label class="rotulo" for="email-de-contato">Email:</label>
                        <input class="caixadeentrada" type="email" id="email-de-contato" name="email" value="<?= htmlspecialchars($fornecedor['Email']) ?>" placeholder="Ex: contato@alfasolucoes.com.br">
                    </div>
                </div>
                <div class="div-linhas">
                    <div class="grupo-form linha3">
                        <label class="rotulo" for="endereco">Endereço:</label>
                        <input class="caixadeentrada" type="text" id="endereco" name="endereco" value="<?= htmlspecialchars($fornecedor['Endereco']) ?>" placeholder="Ex: Rua das Indústrias, 1234">
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