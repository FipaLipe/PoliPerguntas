<?php

require_once "/../utils/conexao.php";

function RetornaUltimaPergunta() {
    $SQL_TEXT = "SELECT id_pergunta FROM perguntas ORDER BY id_pergunta DESC LIMIT 1";
    
    try {
        global $conn;
        $stmt = $conn->prepare($SQL_TEXT);
        $stmt->execute(); 
    
        $result = $stmt->fetchColumn();
        return $result <> '' ? $result : -1;
    
    } catch (Exception $e) {
        return "Erro ao obter última pergunta" . $e->getMessage();
    }
}

?>