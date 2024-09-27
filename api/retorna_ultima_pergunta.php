<?php

require "/../utils/conexao.php";

$SQL_TEXT = "SELECT id_pergunta FROM perguntas ORDER BY id_pergunta DESC LIMIT 1";

try {

    $stmt = $conn->prepare($SQL_TEXT);
    $stmt->execute(); 

    $result = $stmt->fetchColumn();
    echo $result;

} catch (Exception $e) {
    echo "Erro ao obter última pergunta" . $e->getMessage();
}

?>