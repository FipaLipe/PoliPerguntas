<?php
require_once __DIR__ . '/../utils/constants.php';
$erros = explode('|', isset($_SESSION['error'])?$_SESSION['error']:'');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div id="main" class="w-full h-screen bg-zinc-100 flex items-top justify-center p-10">
        <div id="login" class="p-5 w-fit flex flex-col items-center">
            <img src="/public/assets/img/logo-politec.png" alt="logo-politec" class="w-44 justify-self-center mb-6">
            <h1 class="text-xl font-regular text-center mb-5">PoliPerguntas - Acesso</h1>
            <?php
                if (isset($erros)) {
                    foreach ($erros as $erro) {
                        if ($erro != '') {
                            echo '<p class="text-red-500 text-sm"> <span class="font-bold">Erro: </span> '.str_replace($cod_erros, $msg_erros, $erro).' </p>';    
                        }
                    }
                }
            ?>
            <form id="form_cadastro" action="/api/add_user" method="post" class="flex flex-col">
                <input type="text" name="rm" placeholder="RM" class="border-2 rounded-t-lg w-80 h-14 p-4 <?php echo (in_array('falta_rm', $erros) or in_array('23000', $erros))?'border-red-500':'';?>" value="<?php echo isset($_SESSION['rm_cadastro'])?$_SESSION['rm_cadastro']:'' ?>" maxlength="6">
                <input type="text" name="nome" placeholder="Nome" class="border-2 w-80 h-14 p-4 rounded-b-lg <?php echo (in_array('falta_nome', $erros))?'border-red-500':'';?>" value="<?php echo isset($_SESSION['nome_cadastro'])?$_SESSION['nome_cadastro']:'' ?>" maxlength="100">
                <br>
                <input type="password" name="senha" placeholder="Senha" class="border-2 rounded-t-lg w-80 h-14 p-4 <?php echo (in_array('falta_senha', $erros) or in_array('senha_diferente', $erros))?'border-red-500':'';?>" maxlength="50">
                <input type="password" name="confirmar_senha" placeholder="Confirme a senha"
                    class="border-2 rounded-b-lg w-80 h-14 p-4 <?php echo (in_array('senha_diferente', $erros))?'border-red-500':'';?>" maxlength="50">
                <br>
                <button
                    class="transition-all duration-300 w-80 p-3 bg-blue-500 text-white font-semibold rounded-md text-lg hover:bg-blue-600"
                    type="submmit" name="btn-cadastro">Cadastrar</button>
                <a class="text-blue-500 hover:text-blue-600 mt-2 underline decoration-solid text-center cursor-pointer"
                    href="/login">Já tenho uma conta</a>
            </form>
        </div>
    </div>
</body>

</html>

<?php
    unset($_SESSION['error'], $_SESSION['nome_cadastro']);
?>