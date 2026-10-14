<?php

// logout.php
// Encerra a sessão do usuário de forma segura.
// Conceitos: session_destroy, limpeza de cookies, header anti_cache 

// Inicia a sessão para poder destrui-la
session_start();

// Limpa todas as variáveis da sessão (nome, etc).
$_SESSION = array ();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 4230,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destrói completamente a sessão do servidor
session_destroy();

// Cabeçalhos que impedem o navegador de usar páginas em cache
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Redireciona para página de login
header("Location: login.php");
exit();
