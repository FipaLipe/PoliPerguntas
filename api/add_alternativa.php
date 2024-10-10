<?php

require_once "/../utils/get_img.php";
require_once "/retorna_ultima_alternativa.php";
require_once "/../utils/conexao.php";


$SQL_TEXT = "INSERT INTO alternativas(id_alternativa, id_pergunta, correta, texto, imagem) VALUES(:id_alternativa, :id_pergunta, :correta, :texto, :imagem)";

try {
    $data = json_decode($_POST['json']);

    $id_alternativa = RetornaUltimaAlternativa()+1;

    $imagem = GetImg(__DIR__ . '/../public/uploads/alternativas_img/' . $id_alternativa . '.');

    $stmt = $conn->prepare($SQL_TEXT);
    $stmt->bindParam(':id_alternativa', $id_alternativa);
    $stmt->bindParam(':id_pergunta',    $data->id_pergunta);
    $stmt->bindParam(':correta',        $data->correta);
    $stmt->bindParam(':texto',          $data->texto);
    $stmt->bindParam(':imagem',         explode('api/..', $imagem)[1]);

    $stmt->execute();

} catch (Exception $e) {
    echo "Erro ao inserir pergunta no banco de dados: " . $e->getMessage();
}

?>