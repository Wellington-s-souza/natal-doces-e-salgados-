<?php
include 'env.php';

$host = $GLOBALS['env']['DB_HOST'];
$usuario = $GLOBALS['env']['DB_USER'];
$senha = $GLOBALS['env']['DB_PASS'];
$banco = $GLOBALS['env']['DB_NAME'];

$conexao = mysqli_connect($host, $usuario, $senha, $banco);

if (!$conexao) {
  die("Erro na conexão: " . mysqli_connect_error());
}

mysqli_set_charset($conexao, "utf8mb4");
?>