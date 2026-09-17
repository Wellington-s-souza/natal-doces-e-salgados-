<?php
// Lê o arquivo .env e transforma cada linha em uma variável de ambiente
function carregarEnv($caminho) {
  if (!file_exists($caminho)) {
    die("Arquivo .env não encontrado. Copie .env.example para .env e configure.");
  }

  // Lê o arquivo linha por linha, ignorando linhas vazias
  $linhas = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

  foreach ($linhas as $linha) {
    // Ignora comentários (linhas que começam com #)
    if (strpos(trim($linha), '#') === 0) {
      continue;
    }

    // Separa "CHAVE=valor" em duas partes
    list($chave, $valor) = explode('=', $linha, 2);
    $chave = trim($chave);
    $valor = trim($valor);

    // putenv() registra a variável no ambiente do PHP para essa requisição
    putenv("{$chave}={$valor}");
  }
}

carregarEnv(__DIR__ . '/.env');
?>