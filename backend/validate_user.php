<?php
function validaUsuario($rm, $senha){

    require_once __DIR__ . "/../utils/conexao.php";

    if(empty($rm) || empty($senha)){
        return '';
    }

    $SQL_TEXT = "SELECT senha, id_user FROM users WHERE rm = :rm";

    try {
        $stmt = $conn->prepare($SQL_TEXT);
        $stmt->bindParam(':rm', $rm);

        $stmt->execute();
        $dados = $stmt->fetch();
        $hashed_senha = $dados['senha'];

        $result = password_verify($senha, $hashed_senha);
        return $result?$dados['id_user']:'';

    } catch (Exception $e) {
        return "Erro ao validar usuário" . $e->getMessage();
    }
}
function validaAdmin($rm, $senha){
    require_once __DIR__ . "/../utils/conexao.php";
    global $conn;

    if(empty($rm) || empty($senha)){
        return '';
    }
    
    $SQL_TEXT = "SELECT admin, senha FROM users WHERE rm = :rm";

    try {
        $stmt = $conn->prepare($SQL_TEXT);
        $stmt->bindParam(':rm', $rm);

        $stmt->execute();
        $dados = $stmt->fetch();
        $hashed_senha = $dados['senha'];

        $result = password_verify($senha, $hashed_senha);
        return $result?$dados['admin']:'';

    } catch (Exception $e) {
        return "Erro ao validar usuário" . $e->getMessage();
    }
}


?>