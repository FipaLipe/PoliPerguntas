<?php

require_once 'validate_user.php';

$rm = $_POST['rm'];
$senha = $_POST['senha'];
$error = '';

$_SESSION['error'] = '';
$_SESSION['rm_cadastro'] =  $rm;

if (empty($rm)) {
    $error = $error . '|falta_rm';
}

if (empty($senha)) {
    $error = $error . '|falta_senha';
}

if ($error != '') {
    $_SESSION['error'] = $error;
    header('Location: /login');
    exit();
}

$loginCorreto = validaUsuario($rm, $senha);

if (!$loginCorreto) {
    $error = $error . '|senha_incorreta';
    $_SESSION['error'] = $error;
    header('Location: /login');
} else {
    $_SESSION['user'] = $rm;
    $_SESSION['senha'] = password_hash($senha, PASSWORD_DEFAULT);
    header('Location: /home');
}

?>