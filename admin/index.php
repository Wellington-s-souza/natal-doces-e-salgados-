<?php
// Primeira linha: verifica se está logado (redireciona se não estiver)
include 'verifica_sessao.php';

// Conexão com o banco (o "../" porque estamos dentro da pasta admin/)
include '../conexao.php';

// Busca todos os produtos, ordenados por categoria e depois por nome
$sql = "SELECT * FROM produtos ORDER BY categoria, nome";
$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Painel Administrativo</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div class="admin-container">
    <div class="admin-header">
      <h2>Painel Administrativo</h2>
      <a href="adicionar.php" class="btn">+ Adicionar Produto</a>
      <!-- $_SESSION['usuario'] guarda o nome de quem logou, definido no login.php -->
      <a href="novidades.php" class="btn">Gerenciar Novidades</a>
      <p>Olá, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!
        <a href="logout.php">Sair</a>
      </p>
    </div>
  <div class="admin-tabela-wrapper">
    <table class="admin-tabela">
      <thead>
        <tr>
          <th>Imagem</th>
          <th>Nome</th>
          <th>Categoria</th>
          <th>Descrição</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Percorre cada produto encontrado no banco, um de cada vez
        while ($produto = mysqli_fetch_assoc($resultado)) {
          echo '<tr>';
          echo '<td><img src="../img/' . htmlspecialchars($produto['imagem']) . '" width="60"></td>';
          echo '<td>' . htmlspecialchars($produto['nome']) . '</td>'; 
          echo '<td>' . htmlspecialchars($produto['categoria']) . '</td>';
          echo '<td>' . htmlspecialchars($produto['descricao']) .'</td>';
          
// $produto['id'] identifica exatamente qual produto foi clicado
// Passamos ele pela URL (?id=...) para que a próxima página saiba qual excluir/editar
echo '<td>
  <a href="editar.php?id=' . $produto['id'] . '" class="btn">Editar</a>
  <a href="excluir.php?id=' . $produto['id'] . '" class="btn btn-excluir" onclick="return confirm(\'Tem certeza que deseja excluir este produto?\')">Excluir</a>
</td>';

    }
        ?>
      </tbody>
    </table>
</div>
  </div>
</body>
</html>