<?php
require_once __DIR__ . "/../utils/conexao.php";

$SQL_TEXT = "UPDATE perguntas SET id_user_adicionou = :id_user_adicionou, texto = :texto, dt_aberta = :dt_aberta, dt_fechada = :dt_fechada WHERE id_pergunta = :id_pergunta";
$SQL_TEXT_ALT_DEL = "DELETE FROM alternativas WHERE id_pergunta = :id_pergunta";
$SQL_TEXT_ALT = "INSERT INTO alternativas(id_pergunta, correta, texto) VALUES(:id_pergunta, :correta, :texto)";

$id_pergunta = $_POST['id_pergunta'];
$texto = $_POST['texto'];
$session = $_POST['session_name'];
$id_user_adicionou = $_POST['id_user_adicionou'];
$corretas = [];
for ($i = 1; $i <= 5; $i++) {
    array_push($corretas, isset($_POST['correta-'.$i])?($_POST['correta-'.$i] == 'on'):False);
};
$alternativas = [];
for ($i = 1; $i <= 5; $i++) {
    array_push($alternativas, isset($_POST['alternativa-'.$i])?$_POST['alternativa-'.$i]:'');
};
$dt_aberta = $_POST['dt_aberta'];
$dt_fechada = $_POST['dt_fechada'];

$_SESSION['error'] = '';
$_SESSION['pergunta_' . $session] = '';
$_SESSION['alternativas_' . $session] = '';
$_SESSION['corretas_' . $session] = '';
$_SESSION['dt_aberta_' . $session] = '';
$_SESSION['dt_fechada_' . $session] = '';

$error = '';

if (empty($texto)) {
    $error = $error . '|falta_pergunta';
} else {
    $_SESSION['pergunta_' . $session] = $texto;
}

if (empty($alternativas) or array_sum($corretas) <= 0) {
    $error = $error . '|falta_alternativas';
} 

if (!empty($alternativas)){
    $_SESSION['alternativas_' . $session] = implode(';', $alternativas);
}

if (!empty($corretas)){
    $_SESSION['corretas_' . $session] = implode(';', $corretas);
}

if (empty($dt_aberta)) {
    $error = $error . '|falta_dt_aberta';
} else {
    $_SESSION['dt_aberta_' . $session] = $dt_aberta;
}

if (empty($dt_fechada)) {
    $error = $error . '|falta_dt_fechada';
} else {
    $_SESSION['dt_fechada_' . $session] = $dt_fechada;
}

if ($error != '') {
    $_SESSION['error'] = $error;
    // var_dump($alternativas);
    // var_dump($_SESSION);
    header('Location: /' . $session . '?id_pergunta=' . $id_pergunta);
    exit();
}

try {
    $stmtALTDEL = $conn->prepare($SQL_TEXT_ALT_DEL);
    $stmtALTDEL->bindParam('id_pergunta', $id_pergunta);
    $stmtALTDEL->execute();

    $stmt = $conn->prepare($SQL_TEXT);
    $stmt->bindParam(':id_user_adicionou', $id_user_adicionou);
    $stmt->bindParam(':texto', $texto);
    $stmt->bindParam(':dt_aberta', $dt_aberta);
    $stmt->bindParam(':dt_fechada', $dt_fechada);
    $stmt->bindParam('id_pergunta', $id_pergunta);
    $stmt->execute();

    $pergunta = $conn->lastInsertId();
    // echo $pergunta;

    $stmtALT = $conn->prepare($SQL_TEXT_ALT);
    for ($i = 1; $i <= 5; $i++) {
        if (!empty($alternativas[$i])) {
            $stmtALT->bindParam('id_pergunta', $pergunta);
            $stmtALT->bindParam('correta', $corretas[$i]);
            $stmtALT->bindParam('texto', $alternativas[$i]); 
            
            $stmtALT->execute();
        }  
    }

    unset(
        $_SESSION['alternativas_admin/perguntas/cadastro'],
        $_SESSION['corretas_admin/perguntas/cadastro'],
        $_SESSION['dt_aberta_admin/perguntas/cadastro'],
        $_SESSION['dt_fechada_admin/perguntas/cadastro'],
        $_SESSION['texto_admin/perguntas/cadastro']
    );
    switch ($session) {
        case 'admin/perguntas/cadastro':
            header('Location: /admin/perguntas/consulta');
            break;
        default:
            header('Location: /login');
            break;
    }
    exit();

} catch (Exception $e) {
    $error_aux = $e->getMessage();

    $error = $error . '|' . $e->getCode();
    $error = $error . '|' . $e->getMessage();

    $_SESSION['error'] = $error;
    header('Location: /' . $session . '?id_pergunta=' . $id_pergunta);
    exit();
}


?>