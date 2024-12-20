<?php
require_once __DIR__ . "/../utils/conexao.php";

$SQL_TEXT = "INSERT INTO users(rm, nome, senha) VALUES(:rm, :nome, :senha)";

$rm = $_POST['rm'];
$nome = $_POST['nome'];
$senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar_senha'];
$session = $_POST['session_name'];
$admin = isset($_POST['admin']) ? $_POST['admin'] : False;

if ($admin) {
    require_once(__DIR__ . "/../utils/seguranca_admin.php");
    $SQL_TEXT = "INSERT INTO users(rm, nome, senha, admin) VALUES(:rm, :nome, :senha, TRUE)";
}

$_SESSION['error'] = '';
$_SESSION['rm_' . $session] = '';
$_SESSION['nome_' . $session] = '';

$error = '';

if (empty($rm)) {
    $error = $error . '|falta_rm';
} else {
    $_SESSION['rm_' . $session] = $rm;
}

if (empty($nome)) {
    $error = $error . '|falta_nome';
} else {
    $_SESSION['nome_' . $session] = $nome;
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
    header('Location: /' . $session);
    exit();
}

try {
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare($SQL_TEXT);
    $stmt->bindParam(':rm', $rm);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':senha', $senha);

    $stmt->execute();

    switch ($session) {
        case 'cadastro':
            header('Location: /login');
            break;
        case 'admin/usuarios/cadastro':
            header('Location: /admin/usuarios/consulta');
            break;
        default:
            header('Location: /login');
            break;
    }
    exit();

} catch (Exception $e) {
    $error_aux = $e->getMessage();

    $error = $error . '|' . $e->getCode();

    $_SESSION['error'] = $error;
    header('Location: /' . $session);
    exit();
}


?>