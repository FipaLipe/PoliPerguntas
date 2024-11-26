<?php
require_once __DIR__ . "/../utils/conexao.php";

$SQL_TEXT = "UPDATE users SET rm = :rm, nome = :nome";

$id_user = $_POST['id_user'];
$rm = $_POST['rm'];
$nome = $_POST['nome'];
$senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar_senha'];
$session = $_POST['session_name']; 
$admin = isset($_POST['admin']) ? $_POST['admin'] : False;

if (!empty($admin)) {
    require_once(__DIR__ . "/../utils/seguranca_admin.php");
    $SQL_TEXT = $SQL_TEXT . ", admin = :admin";
}
if (!empty($senha)) {
    require_once(__DIR__ . "/../utils/seguranca_admin.php");
    $SQL_TEXT = $SQL_TEXT . ", senha = :senha";
}

$SQL_TEXT = $SQL_TEXT . " WHERE id_user = :id_user";

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

if (isset($senha) && isset($confirmar_senha)) {
    if ($senha != $confirmar_senha) {
        $error = $error . '|senha_diferente';
    }
} else {
    $error = $error . '|senha_diferente';
}

if ($error != '') {
    $_SESSION['error'] = $error;
    header('Location: /' . $session . "?id_user=" . $id_user);
    exit();
}

try {
    if (!empty($senha)) {
        $senha = password_hash($senha, PASSWORD_DEFAULT);
    }

    $stmt = $conn->prepare($SQL_TEXT);
    $stmt->bindParam(':rm', $rm);
    $stmt->bindParam(':nome', $nome);
    if (!empty($senha)) {
        $stmt->bindParam(':senha', $senha);
    }
    if (!empty($admin)) {
        $stmt->bindParam(':admin', $admin);
    }
    
    $stmt->bindParam(':id_user', $id_user);

    $stmt->execute();

    switch ($session) {
        case 'cadastro':
            header('Location: /login');
            break;
        case 'admin/usuarios/cadastro':
            header('Location: /admin/usuarios/consulta');
            break;
        case 'admin/usuarios/atualiza':
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
    header('Location: /' . $session . "?id_user=" . $id_user);
    exit();
}


?>