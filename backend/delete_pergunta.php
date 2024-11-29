<?php
require_once __DIR__ . "/../utils/conexao.php";

$SQL_TEXT = "DELETE FROM perguntas WHERE id_pergunta = :id_pergunta";

$id_pergunta = isset($_REQUEST['id_pergunta']) ? $_REQUEST['id_pergunta'] : '';

$error = '';

if (empty($id_pergunta)) {
    $error = $error . '|falta_pergunta';
}

if ($error != '') {
    $_SESSION['error'] = $error;
    header('Location: /admin/perguntas/consulta');
    exit();
}

try {
    $stmt = $conn->prepare($SQL_TEXT);
    $stmt->bindParam(':id_pergunta', $id_pergunta);

    $stmt->execute();

    header('Location: /admin/perguntas/consulta');
    exit();

} catch (Exception $e) {
    $error_aux = $e->getMessage();

    $error = $error . '|' . $e->getCode();

    $_SESSION['error'] = $error;
    header('Location: /admin/perguntas/consulta');
    exit();
}


?>