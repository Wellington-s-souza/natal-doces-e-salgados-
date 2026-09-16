<?php
include 'verifica_sessao.php';
include '../conexao.php';

if (isset($_GET['id'])) {
  $id = (int) $_GET['id'];

  $sql = "DELETE FROM novidades WHERE id = ?";
  $stmt = mysqli_prepare($conexao, $sql);
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
}

header("Location: novidades.php");
exit;
?>