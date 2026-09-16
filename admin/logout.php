<?php
// Retoma a sessão para poder encerrá-la
session_start();

// Apaga TODAS as variáveis guardadas na sessão atual
session_unset();

// Destrói a sessão por completo
session_destroy();

// Manda o usuário de volta pra tela de login
header("Location: ../login.php");
exit;
?>