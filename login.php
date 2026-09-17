<?php
date_default_timezone_set('America/Sao_Paulo');
session_start();
include 'conexao.php';

$erro = "";
// Pega o IP de quem está acessando
$ip = $_SERVER['REMOTE_ADDR'];
$agora = date('Y-m-d H:i:s');

// Configurações do rate limiting
$maxTentativas = 5;      // Quantas tentativas erradas permitir
$tempoBloqueio = 300;    // Tempo de bloqueio em segundos (300 = 5 minutos)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // PASSO 1: Verifica se esse IP já está bloqueado
  $sqlVerifica = "SELECT * FROM tentativas_login WHERE ip = ?";
  $stmt = mysqli_prepare($conexao, $sqlVerifica);
  mysqli_stmt_bind_param($stmt, "s", $ip);
  mysqli_stmt_execute($stmt);
  $resultado = mysqli_stmt_get_result($stmt);
  $registro = mysqli_fetch_assoc($resultado);

  $bloqueado = false;

  if ($registro && $registro['tentativas'] >= $maxTentativas) {
    // Calcula quanto tempo passou desde a última tentativa
    $tempoDecorrido = time() - strtotime($registro['ultima_tentativa']);

    if ($tempoDecorrido < $tempoBloqueio) {
      $bloqueado = true;
      $minutosRestantes = ceil(($tempoBloqueio - $tempoDecorrido) / 60);
      $erro = "Muitas tentativas erradas. Tente novamente em {$minutosRestantes} minuto(s).";
    } else {
      // Já passou o tempo de bloqueio, reseta o contador
      $sqlReset = "UPDATE tentativas_login SET tentativas = 0 WHERE ip = ?";
      $stmt = mysqli_prepare($conexao, $sqlReset);
      mysqli_stmt_bind_param($stmt, "s", $ip);
      mysqli_stmt_execute($stmt);
    }
  }

  // PASSO 2: Se não estiver bloqueado, processa o login normalmente
  if (!$bloqueado) {
    $usuario = $_POST['usuario'];
    $senhaDigitada = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $usuario);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $usuarioEncontrado = mysqli_fetch_assoc($resultado);

    if ($usuarioEncontrado && password_verify($senhaDigitada, $usuarioEncontrado['senha'])) {
      // LOGIN CERTO: limpa o registro de tentativas desse IP
      $sqlLimpa = "DELETE FROM tentativas_login WHERE ip = ?";
      $stmt = mysqli_prepare($conexao, $sqlLimpa);
      mysqli_stmt_bind_param($stmt, "s", $ip);
      mysqli_stmt_execute($stmt);

      $_SESSION['logado'] = true;
      $_SESSION['usuario'] = $usuarioEncontrado['usuario'];
      header("Location: painel/index.php");
      exit;
    } else {
      // LOGIN ERRADO: registra ou incrementa a tentativa
      if ($registro) {
        $sqlIncrementa = "UPDATE tentativas_login SET tentativas = tentativas + 1, ultima_tentativa = ? WHERE ip = ?";
        $stmt = mysqli_prepare($conexao, $sqlIncrementa);
        mysqli_stmt_bind_param($stmt, "ss", $agora, $ip);
      } else {
        $sqlInsere = "INSERT INTO tentativas_login (ip, tentativas, ultima_tentativa) VALUES (?, 1, ?)";
        $stmt = mysqli_prepare($conexao, $sqlInsere);
        mysqli_stmt_bind_param($stmt, "ss", $ip, $agora);
      }
      mysqli_stmt_execute($stmt);

      $erro = "Usuário ou senha incorretos";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Login - Painel Administrativo</title>
  <meta name="robots" content="noindex, nofollow">
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