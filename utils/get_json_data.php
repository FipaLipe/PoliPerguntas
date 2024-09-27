<?php

$json = file_get_contents("php://input");

if ($json == '') {
    echo "JSON não encontrado!";
}

try {
    $data = json_decode($json);
} catch (Exception $e) {
    echo "Erro ao decodificar JSON: " . $e->getMessage();
}

?>