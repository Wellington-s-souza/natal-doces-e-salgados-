<?php
// Inicia (ou retoma) a sessão do usuário.
// Precisa vir ANTES de qualquer HTML ser enviado ao navegador.
session_start();

// Traz a variável $conexao já configurada nesse arquivo
include 'conexao.php';



// Variável que vai guardar uma mensagem de erro, caso o login falhe
$erro = "";

// Verifica se essa página foi acessada por um envio de formulário (POST)
// ou só por uma visita normal (GET, quando o navegador só carrega a página)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Pega os valores digitados nos campos do formulário
  // ($_POST é um array que guarda tudo que foi enviado pelo <form method="POST">)
  $usuario = $_POST['usuario'];
  $senhaDigitada = $_POST['senha'];

  // Monta a consulta SQL com um "?" no lugar do valor real (placeholder)
  // Isso evita SQL Injection: o valor nunca é colado direto no comando
  $sql = "SELECT * FROM usuarios WHERE usuario = ?";

  // Prepara a consulta (deixa ela "pronta pra usar", mas ainda sem o valor)
  $stmt = mysqli_prepare($conexao, $sql);

  // Substitui o "?" pelo valor de $usuario
  // "s" significa que o valor é do tipo "string" (texto)
  mysqli_stmt_bind_param($stmt, "s", $usuario);

  // Executa a consulta de fato no banco
  mysqli_stmt_execute($stmt);

  // Pega o resultado da consulta
  $resultado = mysqli_stmt_get_result($stmt);

  // Pega a primeira (e única, já que "usuario" é UNIQUE) linha encontrada
  $usuarioEncontrado = mysqli_fetch_assoc($resultado);

  // Verifica duas coisas ao mesmo tempo:
  // 1) Se encontrou algum usuário com esse nome ($usuarioEncontrado não é vazio)
  // 2) Se a senha digitada bate com o hash salvo no banco
  if ($usuarioEncontrado && password_verify($senhaDigitada, $usuarioEncontrado['senha'])) {

    // Login certo! Grava na sessão que esse usuário está autenticado
    $_SESSION['logado'] = true;
    $_SESSION['usuario'] = $usuarioEncontrado['usuario'];

    // Redireciona para a página principal do painel administrativo
    header("Location: admin/index.php");
    exit; // Para a execução do script aqui, por segurança
  } else {
    // Login errado: guarda uma mensagem pra mostrar na tela
    $erro = "Usuário ou senha incorretos";
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Login - Painel Administrativo</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="login-container">
    <h2>Painel Administrativo</h2>

    <?php if ($erro): ?>
      <!-- Essa mensagem só aparece se a variável $erro tiver algum texto -->
      <p class="login-erro"><?php echo htmlspecialchars($erro); ?></p>
    <?php endif; ?>

    <!-- method="POST" envia os dados de forma "escondida" (não aparece na URL) -->
    <!-- action="login.php" diz para onde o formulário deve ser enviado -->
    <form method="POST" action="login.php">
      <label for="usuario">Usuário</label>
      <input type="text" id="usuario" name="usuario" required>

      <label for="senha">Senha</label>
      <input type="password" id="senha" name="senha" required>

      <button type="submit" class="btn">Entrar</button>
    </form>
  </div>
</body>
</html>