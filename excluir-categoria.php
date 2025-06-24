<?php
require_once 'conexao.php';

if (isset($_GET['id']) || !empty($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conexao->prepare("DELETE FROM produtos WHERE Categoria_ID = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    $stmt2 = $conexao->prepare("DELETE FROM categorias WHERE ID = :id");
    $stmt2->bindValue(':id', $id);
    $stmt2->execute();

    header("Location: tabela-categoria.php?mensagemsucesso=Categoria excluida com sucesso!");
    exit();
} else {
    header("Location: tabela-categoria.php?mensagemerro=Categoria não encontrada.");
}
?>