<?php

function load_env($path) {
    if (!file_exists($path)) {
        throw new Exception('.env arquivo não encontrado.');
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        // Ignorar comentários
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Dividir a linha em chave e valor
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        // Definir a variável de ambiente
        putenv("$key=$value");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

// Carregar o arquivo .env
load_env(__DIR__ . '/../.env');

?>