<?php
// salvar_usuario.php
// Recebe os dados do formulário de cadastro e salva o usuário
// no banco.
// Conceitos: POST, password_hash, MySQL, INSERT, verificação
// de E-mail duplicado.

// Inclui o arquivo de conexão com o banco de dados.
include('conexao.php');

// Recebe os dados enviados pelo formulário via método POST.
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

// ==========================================================
// VERIFICAÇÃO DE EMAIL DUPLICADO
// Antes de cadastrar, verifica se o email já existe no banco
// ==========================================================

// Monta a consulta SQL (SELECT) para buscar o email
$sqlVerificar = "SELECT id FROM usuarios WHERE email = '$email'";

// Executa a consulta no MySQL
$resultadoVerificar = mysqli_query($conexao, $sqlVerificar);

// Validação: mysql_num_rows() conta quantos registros 
// foram encontrados.

if (mysqli_num_rows($resultadoVerificar) > 0) {
    // Se o email já existe, redireciona de volta ao cadastro
    // com mensagem de erro
    header("Location: cadastro,php?erro=email");
    exit();
}

// ==========================================================
// CRIPTOGRAFIA DA SENHA
// Nunca armzenamos a senha em texto puro no banco
// ==========================================================
// password_has() gera um hash seguro na senha
// PASSWORD_DEFAULT usa um algoritmo bcrypt (padrão PHP)
$senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

// ==========================================================
// INSERÇÃO NO BANCO (CREATE DO CRUD)
// ==========================================================

$sql = "INSERT INTO usuarios (nome, email, senha) VALUES
('nome', 'email', '$senhaCriptografada')";

// Executa o INSERT no banco de dados
mysqli_query($conexao, $sql);

// Redireciona o usuario para a página de login após um cadastro
// bem-sucedido.
header("Location: login.php");
exit();
                                                                      