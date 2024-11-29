<?php
require_once __DIR__ . "/../utils/conexao.php";

$SQL_TEXT = "INSERT INTO respostas(id_pergunta, id_alternativa, id_user) VALUES(:id_pergunta, :id_alternativa, (SELECT id_user FROM users WHERE rm = :id_user))";
$SQL_TEXT_PONTOS = "UPDATE users SET pontos = pontos + 10 WHERE id_user=(SELECT id_user FROM users WHERE rm = :id_user) AND (EXISTS(SELECT 1 FROM respostas R JOIN alternativas A ON (R.id_alternativa = A.id_alternativa AND R.id_pergunta = A.id_pergunta) WHERE A.correta = True AND R.id_user = (SELECT id_user FROM users WHERE rm = :id_user) AND R.id_pergunta = :id_pergunta))";

$id_user = $_GET['id_user'] ?? '';
$id_pergunta = $_GET['id_pergunta'] ?? '';
$id_alternativa = $_GET['id_alternativa'] ?? '';
$error = '';


try {

    $stmt = $conn->prepare($SQL_TEXT);
    $stmt->bindParam(':id_user', $id_user);
    $stmt->bindParam(':id_pergunta', $id_pergunta);
    $stmt->bindParam(':id_alternativa', $id_alternativa);

    $stmt->execute();

    $stmt2 = $conn->prepare($SQL_TEXT_PONTOS);
    $stmt2->bindParam(':id_user', $id_user);
    $stmt2->bindParam(':id_pergunta', $id_pergunta);

    $stmt2->execute();
    
    echo 'DEU CERTO!';
    header('Location: /home');
    exit();

} catch (Exception $e) {
    $error_aux = $e->getMessage();

    $error = $error . '|' . $e->getCode();

    echo $e->getMessage();

    $_SESSION['error'] = $error;
    header('Location: /home');
    exit();
}


?>