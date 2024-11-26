<?php
require_once __DIR__ . "/../utils/conexao.php";

$SQL_TEXT = "DELETE FROM users WHERE id_user = :id_user";

$id_user = isset($_REQUEST['id_user']) ? $_REQUEST['id_user'] : '';

$error = '';

if (empty($id_user)) {
    $error = $error . '|falta_rm';
}

if ($error != '') {
    $_SESSION['error'] = $error;
    header('Location: /admin/usuarios/consulta');
    exit();
}

try {
    $stmt = $conn->prepare($SQL_TEXT);
    $stmt->bindParam(':id_user', $id_user);

    $stmt->execute();

    header('Location: /admin/usuarios/consulta');
    exit();

} catch (Exception $e) {
    $error_aux = $e->getMessage();

    $error = $error . '|' . $e->getCode();

    $_SESSION['error'] = $error;
    header('Location: /admin/usuarios/consulta');
    exit();
}


?>