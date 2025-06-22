<?php
require_once 'conexao.php';

if (isset($_GET['id']) || !empty($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conexao->prepare("DELETE FROM produtos WHERE ID = ?");
    $stmt->execute([$id]);

    header("Location: tabela-produto.php?mensagemsucesso=Produto excluido com sucesso!");
    exit();
} else {
    header("Location: tabela-produto.php?mensagemerro=Produto não encontrado.");
}
?>