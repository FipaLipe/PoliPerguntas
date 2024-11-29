<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
session_start();
// var_dump($_SESSION);

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


switch ($request) {
    case '/':
        include 'public/login.php';
        break;
    case '/login':
        include 'public/login.php';
        break;
    case '/loggout':
        include 'public/loggout.php';
        break;
    case '/home':
        include 'public/home.php';
        break;
    case '/admin':
        include 'public/admin.php';
        break;
    case '/cadastro';
        include 'public/cadastro.php';
        break;
    case '/acesso_negado';
        include 'public/acesso_negado.php';
        break;
    case '/admin/usuarios';
        include 'public/usuarios/usuario_consulta.php';
        break;
    case '/admin/usuarios/consulta';
        include 'public/usuarios/usuario_consulta.php';
        break;
    case '/admin/usuarios/cadastro';
        include 'public/usuarios/usuario_cadastro.php';
        break;
    case '/admin/usuarios/atualiza';
        include 'public/usuarios/usuario_atualiza.php';
        break;
    case '/admin/perguntas';
        include 'public/perguntas/pergunta_consulta.php';
        break;
    case '/admin/perguntas/consulta';
        include 'public/perguntas/pergunta_consulta.php';
        break;
    case '/admin/perguntas/cadastro';
        include 'public/perguntas/pergunta_cadastro.php';
        break;
    case '/admin/perguntas/atualiza';
        include 'public/perguntas/pergunta_atualiza.php';
        break;
    case '/api/delete_user';
        include 'backend/delete_user.php';
        break;
    case '/api/add_user';
        include 'backend/add_user.php';
        break;
    case '/api/alter_user';
        include 'backend/alter_user.php';
        break;
    case '/api/delete_pergunta';
        include 'backend/delete_pergunta.php';
        break;
    case '/api/add_pergunta';
        include 'backend/add_pergunta.php';
        break;
    case '/api/alter_pergunta';
        include 'backend/alter_pergunta.php';
        break;
    case '/api/valida_login';
        include 'backend/valida_login.php';
        break;
    case '/api/responde';
        include 'backend/responde.php';
        break;
    default;
        echo 'ERRO 404: Caminho não encontrado (' . $request . ')';
}