<?php

require_once "/../utils/conexao.php";
require_once "/../utils/get_json_data.php";

$SQL_TEXT = "SELECT A.id_alternativa,                                " .
            "       A.correta,                                       " .
            "       A.texto,                                         " .
            "       A.imagem                                         " .
            "FROM alternativas A                                     " .
            "WHERE A.id_pergunta  = :id_pergunta                     ";

try {
    global $conn;
    $stmt = $conn->prepare($SQL_TEXT);
    $stmt->bindParam('id_pergunta', $data->id_pergunta);
    $stmt->execute(); 

    $result = $stmt->fetchAll();
    echo json_encode($result);

} catch (Exception $e) {
    echo "Erro ao obter última pergunta" . $e->getMessage();
}

?>