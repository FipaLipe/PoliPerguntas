<?php

require_once(__DIR__ . "/../../utils/seguranca_admin.php");
require_once(__DIR__ . "/../../utils/conexao.php");
require_once __DIR__ . '/../../utils/constants.php';

$stmt = $conn->prepare("SELECT id_user, rm, nome, pontos FROM users ORDER BY pontos");
$stmt->execute();

$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

$erros = explode('|', isset($_SESSION['error']) ? $_SESSION['error'] : '');

$id_user = isset($_GET['id_user']) ? $_GET['id_user'] :  '';

if (empty($id_user)) {
    // var_dump($_SESSION);
    header('Location: /admin/usuarios/consulta');
}

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
        <h1 class="text-xl font-bold mb-5">Atualização de Usuário</h1>
        <div id="cadastro" class="w-full flex flex-col items-start">
            <?php
            if (isset($erros)) {
                foreach ($erros as $erro) {
                    if ($erro != '') {
                        echo '<p class="text-red-500 text-sm"> <span class="font-bold">Erro: </span> ' . str_replace($cod_erros, $msg_erros, $erro) . ' </p>';
                    }
                }
            }

            $stmt = $conn->prepare("SELECT id_user, rm, nome, pontos, admin FROM users WHERE id_user = :id_user");
            $stmt->bindParam('id_user', $id_user);
            $stmt->execute();

            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($dados)) {
                header('Location: /admin/usuarios/consulta');
            } else {
                $dados = $dados[0];
            }
            ?>
            <form id="form_cadastro" action="/api/alter_user" method="post"
                class="flex flex-row flex-wrap content-start w-10/12">
                <input type="hidden" name="session_name"
                    value="admin/usuarios/atualiza" readonly="true">
                <input type="hidden" name="id_user" value="<?php echo $id_user ?>" readonly="true">
                <input type="text" name="rm" placeholder="RM"
                    class="border-2 rounded-l-lg w-3/12 h-14 p-4 <?php echo (in_array('falta_rm', $erros) or in_array('23000', $erros)) ? 'border-red-500' : ''; ?>"
                    maxlength="6" value="<?php echo $dados["rm"] ?>">
                <input type="text" name="nome" placeholder="Nome"
                    class="border-2 w-9/12 h-14 p-4 rounded-r-lg mb-4 <?php echo (in_array('falta_nome', $erros)) ? 'border-red-500' : ''; ?>"
                    maxlength="100" value="<?php echo $dados['nome'] ?>">
                <input type="password" name="senha" placeholder="Nova senha"
                    class="border-2 rounded-t-lg w-full h-14 p-4 <?php echo (in_array('falta_senha', $erros) or in_array('senha_diferente', $erros)) ? 'border-red-500' : ''; ?>"
                    maxlength="50">
                <input type="password" name="confirmar_senha" placeholder="Confirme a nova senha"
                    class="border-2 rounded-b-lg w-full h-14 p-4 mb-4 <?php echo (in_array('senha_diferente', $erros)) ? 'border-red-500' : ''; ?>"
                    maxlength="50">
                <div class="flex items-center gap-2 mb-4 w-full p-1">
                    <input name="admin" type="checkbox" id="ckb_admin" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded" <?php echo $dados['admin'] ? 'checked' : '' ?>>
                    <label for="ckb_admin">Admin</label>
                </div>
                <br>
                <button
                    class="transition-all duration-300 w-80 p-3 bg-blue-500 text-white font-semibold rounded-md text-lg hover:bg-blue-600"
                    type="submmit" name="btn-cadastro">Atualizar</button>
            </form>
        </div>
    </div>
    </div>
</body>

</html>

<?php
unset($_SESSION['error'], $_SESSION[parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)]);
?>