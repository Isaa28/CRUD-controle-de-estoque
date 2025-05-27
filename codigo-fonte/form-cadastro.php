<?php 
        try {
            require_once 'conexao.php';
            if(isset($_POST['nome-empresa'], $_POST['cnpj'], $_POST['senha'])){
                $nomeEmpresa = trim($_POST['nome-empresa']);
                $cnpj = trim($_POST['cnpj']);
                $senha = trim($_POST['senha']);
                if(!empty($nomeEmpresa) && !empty($cnpj) && !empty($senha)){
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
                            header("Location: tela-inicial.php");
                        }else{
                            echo 'Erro ao tentar efetivar cadastro';
                        }
                    }else{
                        throw new PDOException("Erro: Não foi possível executar a declaração sql");
                    }
                }else{
                    echo '[ERRO]Dados não encontrados.';
                }
            }
        }catch (PDOException $erro) {
            echo "Erro: " . $erro->getMessage();
        }
?>