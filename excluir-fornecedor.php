<?php
require_once 'conexao.php';

if (isset($_GET['id']) || !empty($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conexao->prepare("DELETE FROM fornecedores WHERE ID = ?");
    $stmt->execute([$id]);

    header('Location: tabela-fornecedor.php?mensagemsucesso=Fornecedor excluido com sucesso!');
    exit();
} else {
    header('Location: tabela-fornecedor.php?mensagemerro=Fornecedor não encontrado.');
}
?>