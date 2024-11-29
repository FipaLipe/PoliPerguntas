<?php

require_once __DIR__ . "/../utils/conexao.php";

function getRanking()
{  
    $SQL_TEXT = "SELECT U.nome,                                   " .
                "        U.rm,                                    " .
                "        U.pontos                                 " .
                "FROM users U                                     " .
                "ORDER BY pontos DESC LIMIT 10                    ";

    try {
        global $conn;
        $stmt = $conn->prepare($SQL_TEXT);
        $stmt->execute();

        $result = $stmt->fetchAll();
        return $result;

    } catch (Exception $e) {
        return "Erro ao obter ranking" . $e->getMessage();
    }
}
?>