<?php
include 'verifica_sessao.php';
/** @var mysqli $conexao */
include '../conexao.php';

$sql = "SELECT * FROM novidades ORDER BY ordem ASC";
$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Gerenciar Novidades</title>
  <meta name="robots" content="noindex, nofollow">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div class="admin-container">
    <div class="admin-header">
      <h2>Gerenciar Novidades</h2>
      <p>Olá, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!
        <a href="logout.php">Sair</a>
      </p>
    </div>

    <a href="index.php" class="btn">← Produtos</a>
    <a href="adicionar_novidade.php" class="btn">+ Adicionar Imagem</a>

    <div class="admin-tabela-wrapper">
      <table class="admin-tabela">
        <thead>
          <tr>
            <th>Imagem</th>
            <th>Legenda</th>
            <th>Ordem</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($novidade = mysqli_fetch_assoc($resultado)) {
            echo '<tr>';
            echo '<td><img src="../img/' . htmlspecialchars($novidade['imagem']) . '" width="60"></td>';
            echo '<td>' . htmlspecialchars($novidade['legenda']) . '</td>';
            echo '<td>' . $novidade['ordem'] . '</td>';
            echo '<td>
              <a href="editar_novidade.php?id=' . $novidade['id'] . '" class="btn">Editar</a>
              <a href="excluir_novidade.php?id=' . $novidade['id'] . '" class="btn btn-excluir" onclick="return confirm(\'Excluir esta imagem?\')">Excluir</a>
            </td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>