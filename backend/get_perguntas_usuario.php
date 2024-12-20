<?php

require_once "/../utils/conexao.php";
require_once "/../utils/get_json_data.php";

$SQL_TEXT = "SELECT P.id_pergunta,                                   " .
            "       P.texto,                                         " .
            "       P.imagem,                                        " .
            "       P.dt_aberta,                                     " .
            "       P.dt_fechada,                                    " .
            "       U.nome                                           " .
            "FROM perguntas P                                        " .
            "LEFT JOIN users U ON (P.id_user_adicionou = U.id_user)  " .
            "WHERE P.id_user_adicionou  = :id_user                   " .
            "  AND P.situacao = 'A'                                  " .
            "ORDER BY P.DT_CRIADA;                                   ";

try {
    global $conn;
    $stmt = $conn->prepare($SQL_TEXT);
    $stmt->bindParam('id_user', $data->id_user);
    $stmt->execute(); 

    $perguntas = $stmt->fetchAll();
    $result = [];

    
    $SQL_TEXT = "SELECT A.id_alternativa,                                " .
                "       A.correta,                                       " .
                "       A.texto,                                         " .
                "       A.imagem                                         " .
                "FROM alternativas A                                     " .
                "WHERE A.id_pergunta  = :id_pergunta                     ";
    
    $stmt = $conn->prepare($SQL_TEXT);
    
    foreach ($perguntas as $pergunta) {
        try {
            $stmt->bindParam('id_pergunta', $pergunta['id_pergunta']);
            $stmt->execute(); 

            $pergunta['alternativas'] = $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Erro ao obter última pergunta" . $e->getMessage();
        };
        
        array_push($result, $pergunta);
    };

    echo json_encode($result);

} catch (Exception $e) {
    echo "Erro ao obter última pergunta" . $e->getMessage();
}

?>