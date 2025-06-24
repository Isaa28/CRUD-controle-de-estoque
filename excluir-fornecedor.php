<?php
require_once 'conexao.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conexao->prepare("DELETE FROM produtos WHERE Fornecedor_ID = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    
        $stmt2 = $conexao->prepare("DELETE FROM fornecedor_usuario WHERE fornecedor_ID = :id");
        $stmt2->bindValue(':id', $id);
        $stmt2->execute();

        $stmt3 = $conexao->prepare("DELETE FROM fornecedores WHERE ID = :id");
        $stmt3->bindValue(':id', $id);
        $stmt3->execute();

        header('Location: tabela-fornecedor.php?mensagemsucesso=Fornecedor excluído com sucesso!');
        exit();

    } catch (PDOException $e) {
        header('Location: tabela-fornecedor.php?mensagemerro=Erro ao excluir fornecedor: ' . $e->getMessage());
        exit();
    }

} else {
    header('Location: tabela-fornecedor.php?mensagemerro=Fornecedor não encontrado.');
    exit();
}
?>
