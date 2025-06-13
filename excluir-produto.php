<?php
require_once 'conexao.php';

if (isset($_GET['id']) || !empty($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conexao->prepare("DELETE FROM produtos WHERE ID = ?");
    $stmt->execute([$id]);

    header("Location: tabela-produto.php");
    exit();
} else {
    echo "ID inválido.";
}
?>