<?php
// autenticar.php verificar se o email e senha informados estão corretos!
// Conceito deles são: session_start, SELECT no MySQL, password_verify!

// Aqui inicia a sessão de usuario.
// A sessão permite guardar os dados do usuario logado entre as páginas!

// Inclui a conexão com banco de dados.
include("conexao.php");

// Recebe o email e a senha digitados no formulário de login
$email = $_POST['email'];
$senha = $_POST['senha'];

// =========================================================================
// CONSULTA NO BANCO (READ do CRUD)
// Busca o usuario pelo email informado
// =========================================================================

// Montando a consulta SQL SELECT
$sql = "SELECT * FROM usuarios WHERE email = '$email'";

// Executa a consulta e guarda o resultado.
$resultado = mysqli_query($conexao, $sql);

// mysqli_fetch_assoc() transforma a linha do resultado 
// em array associativo
$usuario = mysqli_fetch_assoc($resultado);

// =========================================================================
// VERIFICAÇÃO DA SENHA 
// =========================================================================

// Verifica se o usuario foi encontrado e se a senha esta correta
// passaword_verifiy() compara a senha digitada com o hash salvo
// no banco
if ($usuario && password_verify($senha, $usuario['senha'])) {
    // Login bem-sucedido: guarda o nome do usuario na sessão
    $_SESSION['nome'] = $usuario['nome'];
    // Redireciona para o painel principal
    header("Location: painel.php");
    exit();
} else {
    // Login inválido: redireciona de volta para login
    // com mensagem de erro
    header("Location: login.php?erro=login");
    exit();
}