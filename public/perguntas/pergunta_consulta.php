<?php

require_once(__DIR__ . "/../../utils/seguranca_admin.php");
require_once(__DIR__ . "/../../utils/conexao.php");

$stmt = $conn->prepare("SELECT id_pergunta, texto, imagem, dt_aberta, dt_fechada FROM perguntas");
$stmt->execute();

$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <h1 class="text-xl font-bold mb-5">Consulta de Perguntas</h1>
        <table class="w-full max-w-screen-md text-sm text-left text-gray-800">
            <thead class="text-x text-gray-100 bg-blue-500">
                <tr>
                    <th scope="col" class="px-8 py-3">Texto</th>
                    <th scope="col" class="px-3 py-3">Dt. Aberta</th>
                    <th scope="col" class="px-3 py-3">Dt. Fechada</th>
                    <th scope="col" class="px-6 py-3">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dados as $pergunta) { ?>
                <tr class="bg-white border-b dark:border-gray-700">
                    <td class="px-8 py-4"><?php echo $pergunta["texto"];?></td>
                    <td class="px-3 py-4"><?php echo $pergunta["dt_aberta"];?></td>
                    <td class="px-3 py-4"><?php echo $pergunta["dt_fechada"];?></td>
                    <td class="px-6 py-4">
                        <!-- <a href="<?php echo "/admin/perguntas/atualiza?id_pergunta=".$pergunta["id_pergunta"] ?>">
                            <i class="fa fa-edit mr-2 hover:text-blue-500 transition-all" aria-hidden="true"></i>
                        </a> -->
                        <a href="<?php echo "/api/delete_pergunta?id_pergunta=".$pergunta["id_pergunta"] ?>">
                            <i class="fa fa-x mr-2 hover:text-red-500 transition-all" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>
</body>

</html>