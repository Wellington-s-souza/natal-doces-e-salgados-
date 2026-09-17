<?php
include 'verifica_sessao.php';
/** @var mysqli $conexao */
include '../conexao.php';

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $legenda = $_POST['legenda'];
  $ordem = (int) $_POST['ordem'];
  $imagem = "";

  if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
    $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($extensao, $extensoesPermitidas)) {
      $novoNomeArquivo = uniqid('novidade_') . '.' . $extensao;
      $caminhoDestino = '../img/' . $novoNomeArquivo;

      if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)) {
        $imagem = $novoNomeArquivo;
      } else {
        $erro = "Erro ao mover o arquivo enviado.";
      }
    } else {
      $erro = "Formato de imagem não permitido. Use JPG, PNG ou WEBP.";
    }
  } else {
    $erro = "É necessário selecionar uma imagem.";
  }

  if ($erro === "") {
    $sql = "INSERT INTO novidades (imagem, legenda, ordem) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $imagem, $legenda, $ordem);
    mysqli_stmt_execute($stmt);

    header("Location: novidades.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Adicionar Novidade</title>
  <meta name="robots" content="noindex, nofollow">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div class="admin-container">
    <div class="admin-header admin-header-centralizado">
      <h2>Adicionar Novidade</h2>
    </div>

    <?php if ($erro): ?>
      <p class="login-erro"><?php echo htmlspecialchars($erro); ?></p>
    <?php endif; ?>

    <form method="POST" action="adicionar_novidade.php" enctype="multipart/form-data">
      <label for="legenda">Legenda (texto abaixo da imagem)</label>
      <input type="text" id="legenda" name="legenda" required>

      <label for="ordem">Ordem de exibição (0 = primeira)</label>
      <input type="text" id="ordem" name="ordem" value="0" required>

      <label for="imagem">Imagem</label>
      <input type="file" id="imagem" name="imagem" accept="image/jpeg, image/png, image/webp" required>

      <button type="submit" class="btn">Adicionar</button>
      <a href="novidades.php">Cancelar</a>
    </form>
  </div>
</body>
</html>