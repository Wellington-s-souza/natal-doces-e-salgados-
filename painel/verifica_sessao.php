<?php
// Retoma a sessão iniciada no login.php
// (session_start() precisa ser chamado em TODA página que usa $_SESSION)
session_start();

// Verifica se a variável 'logado' existe na sessão e é verdadeira
// Se a pessoa não passou pelo login.php, essa variável nunca foi criada
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {

  // Se não estiver logado, redireciona de volta para a tela de login
  // O "../" volta uma pasta (de dentro de admin/ para a raiz do projeto)
  header("Location: ../login.php");

  // Para a execução imediatamente - nada depois disso deve rodar
  exit;
}
?>