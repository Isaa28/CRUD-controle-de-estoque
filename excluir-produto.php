<?php
require_once 'conexao.php';

if (isset($_GET['id']) || !empty($_GET['id'])) {
    $id = $_GET['id'];

    $stmt3 = $conexao->prepare("DELETE FROM produtos WHERE ID = :id");
    $stmt3->bindValue(':id', $id);
    $stmt3->execute();

    header("Location: tabela-produto.php?mensagemsucesso=Produto excluido com sucesso!");
    exit();
} else {
    header("Location: tabela-produto.php?mensagemerro=Produto não encontrado.");
}
?>