<?php
include 'verifica_sessao.php';
include '../conexao.php';

if (!isset($_GET['id'])) {
  header("Location: novidades.php");
  exit;
}

$id = (int) $_GET['id'];
$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $legenda = $_POST['legenda'];
  $ordem = (int) $_POST['ordem'];
  $imagem = $_POST['imagem_atual'];

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
  }

  if ($erro === "") {
    $sql = "UPDATE novidades SET imagem = ?, legenda = ?, ordem = ? WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "ssii", $imagem, $legenda, $ordem, $id);
    mysqli_stmt_execute($stmt);

    header("Location: novidades.php");
    exit;
  }
}

$sql = "SELECT * FROM novidades WHERE id = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$novidade = mysqli_fetch_assoc($resultado);

if (!$novidade) {
  header("Location: novidades.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Novidade</title>
  <meta name="robots" content="noindex, nofollow">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div class="admin-container">
    <div class="admin-header admin-header-centralizado">
      <h2>Editar Novidade</h2>
    </div>

    <?php if ($erro): ?>
      <p class="login-erro"><?php echo htmlspecialchars($erro); ?></p>
    <?php endif; ?>

    <form method="POST" action="editar_novidade.php?id=<?php echo $novidade['id']; ?>" enctype="multipart/form-data">
      <label for="legenda">Legenda</label>
      <input type="text" id="legenda" name="legenda" value="<?php echo htmlspecialchars($novidade['legenda']); ?>" required>

      <label for="ordem">Ordem de exibição</label>
      <input type="text" id="ordem" name="ordem" value="<?php echo $novidade['ordem']; ?>" required>

      <label>Imagem atual</label>
      <img src="../img/<?php echo htmlspecialchars($novidade['imagem']); ?>" width="120">

      <input type="hidden" name="imagem_atual" value="<?php echo htmlspecialchars($novidade['imagem']); ?>">

      <label for="imagem">Trocar imagem (opcional)</label>
      <input type="file" id="imagem" name="imagem" accept="image/jpeg, image/png, image/webp">

      <button type="submit" class="btn">Salvar Alterações</button>
      <a href="novidades.php">Cancelar</a>
    </form>
  </div>
</body>
</html>