<?php

require_once "/../utils/conexao.php";

function RetornaUltimaAlternativa() {
    $SQL_TEXT = "SELECT id_alternativa FROM alternativas ORDER BY id_alternativa DESC LIMIT 1";
    
    try {
        global $conn;
        $stmt = $conn->prepare($SQL_TEXT);
        $stmt->execute(); 
    
        $result = $stmt->fetchColumn();
        return $result <> '' ? $result : -1;
    
    } catch (Exception $e) {
        return "Erro ao obter última alternativa" . $e->getMessage();
    }
}
?>