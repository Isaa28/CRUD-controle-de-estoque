<?php
require_once 'conexao.php';

if (isset($_GET['id']) || !empty($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conexao->prepare("DELETE FROM categorias WHERE ID = ?");
    $stmt->execute([$id]);

    header("Location: tabela-categoria.php?mensagemsucesso=Categoria excluida com sucesso!");
    exit();
} else {
    header("Location: tabela-categoria.php?mensagemerro=Categoria não encontrada.");
}
?>