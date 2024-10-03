<?php

require_once "/../utils/get_img.php";
require_once "/retorna_ultima_pergunta.php";
require_once "/../utils/conexao.php";


$SQL_TEXT = "INSERT INTO perguntas(id_user_adicionou, texto, imagem, dt_aberta, dt_fechada) VALUES(:id_user_adicionou, :texto, :imagem,  :dt_aberta, :dt_fechada)";

try {
    $data = json_decode($_POST['json']);

    $id_pergunta = RetornaUltimaPergunta()+1;

    $imagem = GetImg(__DIR__ . '/../public/uploads/perguntas_img/' . $id_pergunta . '.');

    $stmt = $conn->prepare($SQL_TEXT);
    $stmt->bindParam(':id_user_adicionou', $data->id_user_adicionou);
    $stmt->bindParam(':texto',             $data->texto);
    $stmt->bindParam(':imagem',            $imagem);
    $stmt->bindParam(':dt_aberta',         $data->dt_aberta);
    $stmt->bindParam(':dt_fechada',        $data->dt_fechada);

    $stmt->execute();

} catch (Exception $e) {
    echo "Erro ao inserir pergunta no banco de dados: " . $e->getMessage();
}

?>