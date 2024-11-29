<?php

require_once __DIR__ . "/../utils/conexao.php";

function getAlternativas($id_pergunta)
{
    $SQL_TEXT = "SELECT A.id_alternativa,                                " .
        "       A.correta,                                       " .
        "       A.texto,                                         " .
        "       A.imagem                                         " .
        "FROM alternativas A                                     " .
        "WHERE A.id_pergunta  = :id_pergunta                     " .
        "ORDER BY rand()                                         ";

    try {
        global $conn;
        $stmt = $conn->prepare($SQL_TEXT);
        $stmt->bindParam('id_pergunta', $id_pergunta);
        $stmt->execute();

        $result = $stmt->fetchAll();
        return $result;

    } catch (Exception $e) {
        return "Erro ao obter última pergunta" . $e->getMessage();
    }
}
?>