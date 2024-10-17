<?php

require_once "/../utils/conexao.php";
require_once "/../utils/get_json_data.php";

$SQL_TEXT = "SELECT senha FROM users WHERE rm = :rm";

try {

    $stmt = $conn->prepare($SQL_TEXT);
    $stmt->bindParam(':rm', $data->rm);

    $stmt->execute();
    $hashed_senha = $stmt->fetchColumn();

    $result = password_verify($data->senha, $hashed_senha);
    echo $result;

} catch (Exception $e) {
    echo "Erro ao validar usuário" . $e->getMessage();
}

?>