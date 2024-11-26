<?php

require_once(__DIR__ . "/../../utils/seguranca_admin.php");
require_once(__DIR__ . "/../../utils/conexao.php");
require_once __DIR__ . '/../../utils/constants.php';

$stmt = $conn->prepare("SELECT id_user, rm, nome, pontos FROM users ORDER BY pontos");
$stmt->execute();

$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

$erros = explode('|', isset($_SESSION['error']) ? $_SESSION['error'] : '');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>PoliPerguntas</title>
</head>

<body>
    <?php require __DIR__ . "/../../utils/menu.php"; ?>
    <div class="relative w-full h-full p-10" id="content">
        <h1 class="text-xl font-bold mb-5">Cadastro de Usuários</h1>
        <div id="cadastro" class="w-full flex flex-col items-start">
            <?php
            if (isset($erros)) {
                foreach ($erros as $erro) {
                    if ($erro != '') {
                        echo '<p class="text-red-500 text-sm"> <span class="font-bold">Erro: </span> ' . str_replace($cod_erros, $msg_erros, $erro) . ' </p>';
                    }
                }
            }
            ?>
            <form id="form_cadastro" action="/api/add_user" method="post"
                class="flex flex-row flex-wrap content-start w-10/12">
                <input type="hidden" name="session_name" value="admin/usuarios/cadastro" readonly="true">
                <input type="text" name="rm" placeholder="RM"
                    class="border-2 rounded-l-lg w-3/12 h-14 p-4 <?php echo (in_array('falta_rm', $erros) or in_array('23000', $erros)) ? 'border-red-500' : ''; ?>"
                    maxlength="6">
                <input type="text" name="nome" placeholder="Nome"
                    class="border-2 w-9/12 h-14 p-4 rounded-r-lg mb-4 <?php echo (in_array('falta_nome', $erros)) ? 'border-red-500' : ''; ?>"
                    value="<?php echo isset($_SESSION['nome_cadastro']) ? $_SESSION['nome_cadastro'] : '' ?>"
                    maxlength="100">
                <input type="password" name="senha" placeholder="Senha"
                    class="border-2 rounded-t-lg w-full h-14 p-4 <?php echo (in_array('falta_senha', $erros) or in_array('senha_diferente', $erros)) ? 'border-red-500' : ''; ?>"
                    maxlength="50">
                <input type="password" name="confirmar_senha" placeholder="Confirme a senha"
                    class="border-2 rounded-b-lg w-full h-14 p-4 mb-4 <?php echo (in_array('senha_diferente', $erros)) ? 'border-red-500' : ''; ?>"
                    maxlength="50">
                <div class="flex items-center gap-2 mb-4 w-full p-1">
                    <input name="admin" type="checkbox" id="ckb_admin"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounde">
                    <label for="ckb_admin">Admin</label>
                </div>
                <br>
                <button
                    class="transition-all duration-300 w-80 p-3 bg-blue-500 text-white font-semibold rounded-md text-lg hover:bg-blue-600"
                    type="submmit" name="btn-cadastro">Cadastrar</button>
            </form>
        </div>
    </div>
    </div>
</body>

</html>

<?php
    unset($_SESSION['error'], $_SESSION['rm_admin/usuarios/cadastro'], $_SESSION['nome_admin/usuarios/cadastro']);
?>