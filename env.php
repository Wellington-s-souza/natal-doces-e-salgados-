<?php
// Lê o arquivo .env e guarda os valores num array global,
// em vez de usar putenv()/getenv() (que pode estar desabilitado em hospedagens gratuitas)
function carregarEnv($caminho) {
  if (!file_exists($caminho)) {
    die("Arquivo .env não encontrado. Copie .env.example para .env e configure.");
  }

  $linhas = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  $variaveis = [];

  foreach ($linhas as $linha) {
    if (strpos(trim($linha), '#') === 0) {
      continue;
    }

    list($chave, $valor) = explode('=', $linha, 2);
    $variaveis[trim($chave)] = trim($valor);
  }

  return $variaveis;
}

// Guarda o resultado numa variável global, acessível em outros arquivos
$GLOBALS['env'] = carregarEnv(__DIR__ . '/.env.example');
?>