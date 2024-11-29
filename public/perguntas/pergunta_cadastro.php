<?php

require_once(__DIR__ . "/../../utils/seguranca_admin.php");
require_once(__DIR__ . "/../../utils/conexao.php");
require_once __DIR__ . '/../../utils/constants.php';

$stmt = $conn->prepare("SELECT id_user FROM users where rm = :rm");
$stmt->bindParam('rm', $_SESSION['user']);
$stmt->execute();

$dados = $stmt->fetchColumn();

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
        <h1 class="text-xl font-bold mb-5">Cadastro de Perguntas</h1>
        <div id="cadastro" class="w-full flex flex-col items-start">
            <?php
            if (isset($erros)) {
                foreach ($erros as $erro) {
                    if ($erro != '') {
                        echo '<p class="text-red-500 text-sm"> <span class="font-bold">Erro: </span> ' . str_replace($cod_erros, $msg_erros, $erro) . ' </p>';
                    }
                }
            }
            // var_dump($dados);
            // var_dump($_SESSION);
            ?>
            <form id="form_cadastro" action="/api/add_pergunta" method="post"
                class="flex flex-row flex-wrap content-start w-10/12">
                <input type="hidden" name="session_name" value="admin/perguntas/cadastro" readonly="true">
                <input type="hidden" name="id_user_adicionou" value="<?php echo $dados?>" readonly="true">
                <textarea name="texto" placeholder="Pergunta"
                    class="border-2 rounded-lg w-full h-28 p-4 mb-4 <?php echo in_array('falta_pergunta', $erros) ? 'border-red-500' : ''; ?>"
                    maxlength="255" ><?php echo isset($_SESSION['pergunta_admin/perguntas/cadastro'])?$_SESSION['pergunta_admin/perguntas/cadastro']:'';?> </textarea>

                <?php for ($i = 1; $i <= 5; $i++) { 
                    $texto_alt = isset($_SESSION['alternativas_admin/perguntas/cadastro'])?(isset(explode(';',$_SESSION['alternativas_admin/perguntas/cadastro'])[$i-1])?explode(';',$_SESSION['alternativas_admin/perguntas/cadastro'])[$i-1]:''):'';
                    $correta = isset($_SESSION['corretas_admin/perguntas/cadastro'])?(isset(explode(';',$_SESSION['corretas_admin/perguntas/cadastro'])[$i-1])?explode(';',$_SESSION['corretas_admin/perguntas/cadastro'])[$i-1]:False):False;
                    ?>
                    <div class="flex items-center gap-2 w-full p-1">
                        <input name="correta-<?php echo $i ?>" type="checkbox"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-lg accent-green-500 <?php echo in_array('falta_alternativas', $erros) ? 'border-red-500' : ''; ?>" <?php echo $correta?'checked':'' ?> >
                        <input type="texto" name="alternativa-<?php echo $i ?>" placeholder="Alternativa"
                            class="border-2 rounded-lg w-full h-14 p-4 <?php echo in_array('falta_alternativas', $erros) ? 'border-red-500' : ''; ?>"
                            maxlength="255" value = "<?php  echo $texto_alt?>">
                    </div>
                <?php } ?>

                <label for="dt_aberta" class="w-6/12 mt-6">Dt. Abertura</label>
                <label for="dt_fechada" class="w-6/12 mt-6">Dt. Fechamento</label>
                <input type="datetime-local" name="dt_aberta" placeholder="Dt. Abertura"
                    class="border-2 rounded-l-lg w-6/12 h-14 p-4 <?php echo (in_array('falta_dt_aberta', $erros)) ? 'border-red-500' : ''; ?>"
                    maxlength="255" value = "<?php  echo $_SESSION['dt_aberta_admin/perguntas/cadastro']?? ''?>">
                <input type="datetime-local" name="dt_fechada" placeholder="Dt. Abertura"
                    class="border-2 rounded-r-lg w-6/12 h-14 p-4 mb-4 <?php echo (in_array('falta_dt_fechada', $erros)) ? 'border-red-500' : ''; ?>"
                    maxlength="255" value = "<?php  echo $_SESSION['dt_fechada_admin/perguntas/cadastro'] ?? ''?>">
                <br>
                <button
                    class="transition-all duration-300 mt-4 w-full p-3 bg-blue-500 text-white font-semibold rounded-md text-lg hover:bg-blue-600"
                    type="submmit" name="btn-cadastro">Cadastrar</button>
            </form>
        </div>
    </div>
    </div>
</body>

</html>

<?php
unset($_SESSION['error'],
      $_SESSION['pergunta_admin/perguntas/cadastro'],
      $_SESSION['alternativas_admin/perguntas/cadastro'],
      $_SESSION['corretas_admin/perguntas/cadastro'],
      $_SESSION['dt_aberta_admin/perguntas/cadastro'],
      $_SESSION['dt_fechada_admin/perguntas/cadastro']);
?>