<?php

function GetImg($caminho_imagem) {
    if (!isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        echo "Nenhuma imagem foi enviada ou houve um erro no envio.";
        return '';
    }

    if($_FILES['imagem']['name'] == '') {
        return '';
    }

    $allowedTypes = ['image/jpeg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif'];
        
    if (!in_array($_FILES['imagem']['type'], $allowedTypes)) {
        echo "Tipo de arquivo não permitido. (Tipos permitidos: .jpeg | .jpg | .png | .gif | .webp | .avif )";
        return '';
    }

    $caminho_imagem = $caminho_imagem . explode('/',$_FILES['imagem']['type'])[1];

    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_imagem)) {
        return $caminho_imagem;
    } else {
        return;
    };
}

?>