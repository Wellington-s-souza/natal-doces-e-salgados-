<?php
include 'verifica_sessao.php';
include '../conexao.php';

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $nome = $_POST['nome'];
  $descricao = $_POST['descricao'];
  $categoria = $_POST['categoria'];
  $imagem = ""; // Começa vazio - só é preenchido se o upload der certo

  // Diferente do editar.php, aqui a imagem é OBRIGATÓRIA
  // (não faz sentido criar um produto novo sem nenhuma foto)
  if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {

    $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
    $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($extensao, $extensoesPermitidas)) {
      $novoNomeArquivo = uniqid('produto_') . '.' . $extensao;
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
    // Se não veio nenhum arquivo válido, é um erro (diferente do editar, onde é opcional)
    $erro = "É necessário selecionar uma imagem.";
  }

  // Só insere no banco se passou por todas as validações sem erro
  if ($erro === "") {
    $sql = "INSERT INTO produtos (nome, descricao, categoria, imagem, destaque) VALUES (?, ?, ?, ?, 0)";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $nome, $descricao, $categoria, $imagem);
    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Adicionar Produto</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div class="admin-container">
    <div class="admin-header admin-header-centralizado">
    <h2>Adicionar Produto</h2>
</div>
    <?php if ($erro): ?>
      <p class="login-erro"><?php echo htmlspecialchars($erro); ?></p>
    <?php endif; ?>

    <form method="POST" action="adicionar.php" enctype="multipart/form-data">

      <label for="nome">Nome</label>
      <!-- Repare que aqui NÃO tem value="..." - o campo começa vazio -->
      <input type="text" id="nome" name="nome" required>

      <label for="descricao">Descrição</label>
      <textarea id="descricao" name="descricao" required></textarea>

      <label for="categoria">Categoria</label>
      <select id="categoria" name="categoria">
        <option value="doce">Doce</option>
        <option value="salgado">Salgado</option>
      </select>

      <label for="imagem">Imagem do produto</label>
      <input type="file" id="imagem" name="imagem" accept="image/jpeg, image/png, image/webp" required>

      <button type="submit" class="btn">Adicionar Produto</button>
      <a href="index.php">Cancelar</a>
    </form>
  </div>
</body>
</html>