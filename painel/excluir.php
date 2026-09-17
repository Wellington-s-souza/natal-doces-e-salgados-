<?php
// Sempre confere login antes de qualquer ação no admin
include 'verifica_sessao.php';
include '../conexao.php';

// Verifica se o parâmetro 'id' foi realmente enviado pela URL
// Isso evita erro caso alguém acesse excluir.php sem nenhum id
if (isset($_GET['id'])) {

  // (int) converte o valor para número inteiro
  // Isso é uma proteção extra: mesmo vindo da URL (que o usuário pode editar manualmente),
  // garantimos que só um número seja usado, nunca texto malicioso
  $id = (int) $_GET['id'];

  // Prepared statement, mesma lógica de segurança do login
  $sql = "DELETE FROM produtos WHERE id = ?";
  $stmt = mysqli_prepare($conexao, $sql);
  mysqli_stmt_bind_param($stmt, "i", $id); // "i" = integer (número inteiro)
  mysqli_stmt_execute($stmt);
}

// Depois de excluir (ou se não tinha id nenhum), volta para a listagem
header("Location: index.php");
exit;
?>