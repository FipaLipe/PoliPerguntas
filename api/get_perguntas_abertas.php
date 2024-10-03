<?php

require_once "/../utils/conexao.php";

$SQL_TEXT = "SELECT P.id_pergunta,                                   " .
            "       P.texto,                                         " .
            "       P.imagem,                                        " .
            "       P.dt_aberta,                                     " .
            "       P.dt_fechada,                                    " .
            "       U.nome                                           " .
            "FROM perguntas P                                        " .
            "LEFT JOIN users U ON (P.id_user_adicionou = U.id_user)  " .
            "WHERE P.dt_aberta  < CURRENT_TIMESTAMP                  " .
            "  AND P.dt_fechada > CURRENT_TIMESTAMP                  " .
            "  AND P.situacao = 'A'                                  " .
            "ORDER BY P.DT_CRIADA;                                   ";

try {
    global $conn;
    $stmt = $conn->prepare($SQL_TEXT);
    $stmt->execute(); 

    $result = $stmt->fetchAll();
    echo json_encode($result);

} catch (Exception $e) {
    echo "Erro ao obter última pergunta" . $e->getMessage();
}

?>