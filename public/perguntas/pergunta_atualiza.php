<?php

require_once(__DIR__ . "/../../utils/seguranca_admin.php");
require_once(__DIR__ . "/../../utils/conexao.php");
require_once __DIR__ . '/../../utils/constants.php';

$id_pergunta = $_GET['id_pergunta'] ?? '';

$erros = explode('|', isset($_SESSION['error']) ? $_SESSION['error'] : '');

if (empty($id_pergunta)) {
    header('Location: admin/perguntas/consulta');
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

            $stmt = $conn->prepare("SELECT P.texto, P.id_user_adicionou, P.dt_aberta, P.dt_fechada, A.texto as texto_alt, A.correta FROM perguntas P LEFT JOIN alternativas A ON (P.id_pergunta = A.id_pergunta) WHERE P.id_pergunta = :id_pergunta");
            $stmt->bindParam('id_pergunta', $id_pergunta);
            $stmt->execute();

            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($dados)) {
                header('Location: /admin/usuarios/consulta');
            }
            ?>
            <form id="form_cadastro" action="/api/alter_pergunta" method="post"
                class="flex flex-row flex-wrap content-start w-10/12">
                <input type="hidden" name="session_name" value="admin/perguntas/atualiza" readonly="true">
                <input type="hidden" name="id_user_adicionou" value="<?php echo $dados[0]['id_user_adicionou']?>" readonly="true">
                <input type="hidden" name="id_pergunta" value="<?php echo $id_pergunta?>" readonly="true">
                <textarea name="texto" placeholder="Pergunta"
                    class="border-2 rounded-lg w-full h-28 p-4 mb-4 <?php echo in_array('falta_pergunta', $erros) ? 'border-red-500' : ''; ?>"
                    maxlength="255" ><?php echo $dados[0]['texto']?> </textarea>

                <?php 
                $i = 1;
                foreach ($dados as $alternativa) { 
                    $texto_alt = $alternativa['texto_alt'] ?? '';
                    $correta = $alternativa['correta'] ?? '';
                    ?>
                    <div class="flex items-center gap-2 w-full p-1">
                        <input name="correta-<?php echo $i ?>" type="checkbox"
                            class="w-4 h-4 text-blue-600 bg-gray- 100 border-gray-300 rounded-lg accent-green-500 <?php echo in_array('falta_alternativas', $erros) ? 'border-red-500' : ''; ?>" <?php echo $correta?'checked':'' ?> >
                        <input type="texto" name="alternativa-<?php echo $i ?>" placeholder="Alternativa"
                            class="border-2 rounded-lg w-full h-14 p-4 <?php echo in_array('falta_alternativas', $erros) ? 'border-red-500' : ''; ?>"
                            maxlength="255" value = "<?php  echo $texto_alt?>">
                    </div>
                <?php $i++;
                } while ($i <= 5) {?>
                    <div class="flex items-center gap-2 w-full p-1">
                        <input name="correta-<?php echo $i ?>" type="checkbox"
                            class="w-4 h-4 text-blue-600 bg-gray- 100 border-gray-300 rounded-lg accent-green-500 <?php echo in_array('falta_alternativas', $erros) ? 'border-red-500' : ''; ?>"  >
                        <input type="texto" name="alternativa-<?php echo $i ?>" placeholder="Alternativa"
                            class="border-2 rounded-lg w-full h-14 p-4 <?php echo in_array('falta_alternativas', $erros) ? 'border-red-500' : ''; ?>"
                            maxlength="255"">
                    </div>
                <?php $i++;} ?>


                <label for="dt_aberta" class="w-6/12 mt-6">Dt. Abertura</label>
                <label for="dt_fechada" class="w-6/12 mt-6">Dt. Fechamento</label>
                <input type="datetime-local" name="dt_aberta" placeholder="Dt. Abertura"
                    class="border-2 rounded-l-lg w-6/12 h-14 p-4 <?php echo (in_array('falta_dt_aberta', $erros)) ? 'border-red-500' : ''; ?>"
                    maxlength="255" value = "<?php  echo $dados[0]['dt_aberta']?>">
                <input type="datetime-local" name="dt_fechada" placeholder="Dt. Abertura"
                    class="border-2 rounded-r-lg w-6/12 h-14 p-4 mb-4 <?php echo (in_array('falta_dt_fechada', $erros)) ? 'border-red-500' : ''; ?>"
                    maxlength="255" value = "<?php  echo $dados[0]['dt_fechada']?>">
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