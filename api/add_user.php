<?php

require_once "/../utils/conexao.php";
require_once "/../utils/get_json_data.php";

$SQL_TEXT = "INSERT INTO users(rm, nome, senha) VALUES(:rm, :nome, :senha)";

try {

    $stmt = $conn->prepare($SQL_TEXT);
    $stmt->bindParam(':rm',    $data->rm);
    $stmt->bindParam(':nome',  $data->nome);
    $stmt->bindParam(':senha', password_hash($data->senha, PASSWORD_DEFAULT));

    $stmt->execute();

} catch (Exception $e) {
    echo "Erro ao inserir usuário no banco de dados: " . $e->getMessage();
}

?>