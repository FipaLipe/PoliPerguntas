<?php
require_once __DIR__ . "/../utils/conexao.php";

$SQL_TEXT = "INSERT INTO users(rm, nome, senha) VALUES(:rm, :nome, :senha)";

$rm = $_POST['rm'];
$nome = $_POST['nome'];
$senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar_senha'];

$_SESSION['error'] = '';
$_SESSION['rm_cadastro'] = '';
$_SESSION['nome_cadastro'] = '';

$error = '';

if (empty($rm)) {
    $error = $error . '|falta_rm';
} else {
    $_SESSION['rm_cadastro'] =  $rm;
}

if (empty($nome)) {
    $error = $error . '|falta_nome';
} else {
    $_SESSION['nome_cadastro'] = $nome;
}

if (empty($senha)) {
    $error = $error . '|falta_senha';
}

if (isset($senha) && isset($confirmar_senha)) {
    if ($senha != $confirmar_senha) {
        $error = $error . '|senha_diferente';
    }
} else {
    $error = $error . '|senha_diferente';
}

if ($error != '') {
    $_SESSION['error'] = $error;
    // echo $_SESSION['error'];
    var_dump($_SESSION);
    header('Location: /cadastro');
    exit();
}

try {
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare($SQL_TEXT);
    $stmt->bindParam(':rm', $_POST['rm']);
    $stmt->bindParam(':nome', $_POST['nome']);
    $stmt->bindParam(':senha', $senha);

    $stmt->execute();

    header('Location: /login');
    exit();

} catch (Exception $e) {
    $error_aux = $e->getMessage();

    $error = $error . '|' . $e->getCode();

    $_SESSION['error'] = $error;
    header('Location: /cadastro');
    exit();
}


?>