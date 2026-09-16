<?php
include 'verifica_sessao.php';
include '../conexao.php';

// Verifica se veio um id pela URL (ex: editar.php?id=3)
if (!isset($_GET['id'])) {
  header("Location: index.php");
  exit;
}

$id = (int) $_GET['id'];
$erro =""; // Vamos usar isso para mostrar mensagens de validação do upload

// ETAPA 1: Se o formulário foi enviado (POST), atualiza o produto no banco
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Pega os valores digitados no formulário
  $nome = $_POST['nome'];
  $descricao = $_POST['descricao'];
  $categoria = $_POST['categoria'];

// Pega o nome da imagem ATUAL (que já estava salva), como valor padrão
// Isso é importante: se a pessoa não enviar uma foto nova, mantemos a antiga
  $imagem = $_POST['imagem_atual'];

// $_FILES é um array especial que guarda informações sobre arquivos enviados
// ['imagem']['error'] === UPLOAD_ERR_OK significa "um arquivo foi enviado com sucesso"
// Se o campo ficou vazio, o erro vem como UPLOAD_ERR_NO_FILE, e pulamos essa parte  
 if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK){

 // Pega só a extensão do arquivo enviado (ex: "jpg", "png"), sempre em minúsculo
$extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));

// Lista de extensões que vamos aceitar - qualquer outra coisa é recusada
$extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];

if (in_array($extensao, $extensoesPermitidas)){
// Gera um nome de arquivo ÚNICO, para nunca sobrescrever uma imagem existente
// uniqid() cria uma sequência baseada no horário atual, praticamente impossível de repetir
$novoNomeArquivo = uniqid('produto_') . '.' . $extensao;

// Caminho completo de onde o arquivo vai ser salvo no servidor
$caminhoDestino = '../img/' . $novoNomeArquivo;

if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)){
 // Deu certo! Atualiza a variável $imagem para o novo nome de arquivo
 $imagem = $novoNomeArquivo;
}  else{
   $erro = "Erro ao mover o arquivo enviado.";
}
} else{
  $erro = "Formato de imagem não permitido. Use JPG, PNG ou WEBP.";

  } 
}
// Só atualiza o banco se não houve erro de validação acima
if ($erro ===""){
$sql = "UPDATE produtos SET nome = ?, descricao = ?, categoria = ?, imagem = ? WHERE id = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "ssssi", $nome, $descricao, $categoria, $imagem, $id);
mysqli_stmt_execute($stmt);

header("Location: index.php");
exit;
 }
}


// ETAPA 2: Se chegou aqui, é porque a página foi só VISITADA (GET)
// Então buscamos os dados atuais do produto para preencher o formulário
$sql = "SELECT * FROM produtos WHERE id = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$produto = mysqli_fetch_assoc($resultado);

// Se não encontrou nenhum produto com esse id, volta para a listagem
if (!$produto) {
  header("Location: index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Produto</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div class="admin-container">
   <div class="admin-header admin-header-centralizado">
    <h2>Editar Produto</h2>
   </div>
    <?php if ($erro): ?>
    <p class="login-erro"> <?php echo htmlspecialchars($erro); ?></p>
    <?php endif; ?>

    <!-- enctype="multipart/form-data" é OBRIGATÓRIO sempre que o formulário envia arquivos -->
    <!-- Sem isso, o PHP não consegue processar o upload corretamente -->
    <form method="POST" action="editar.php?id=<?php echo $produto['id']; ?>" enctype="multipart/form-data">

      <label for="nome">Nome</label>
      <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>

      <label for="descricao">Descrição</label>
      <textarea id="descricao" name="descricao" required><?php echo htmlspecialchars($produto['descricao']); ?></textarea>

      <label for="categoria" class="categoria">Categoria</label>
      <select id="categoria" name="categoria">
        <option value="doce" <?php if ($produto['categoria'] === 'doce') echo 'selected'; ?>>Doce</option>
        <option value="salgado" <?php if ($produto['categoria'] === 'salgado') echo 'selected'; ?>>Salgado</option>
      </select>

      <!-- Mostra a imagem atual, só como referência visual -->
      <label>Imagem atual</label>
      <img src="../img/<?php echo htmlspecialchars($produto['imagem']); ?>" width="120" style="display: block; margin-bottom: 10px;">

      <!-- Campo escondido: guarda o nome da imagem atual, caso nenhuma nova seja enviada -->
      <input type="hidden" name="imagem_atual" value="<?php echo htmlspecialchars($produto['imagem']); ?>">

      <label for="imagem">Trocar imagem (opcional)</label>
      <input type="file" id="imagem" name="imagem" accept="image/jpeg, image/png, image/webp">

      <button type="submit" class="btn">Salvar Alterações</button>
      <a href="index.php">Cancelar</a>
    </form>
  </div>
</body>
</html>