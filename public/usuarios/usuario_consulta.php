<?php

require_once(__DIR__ . "/../../utils/seguranca_admin.php");
require_once(__DIR__ . "/../../utils/conexao.php");

$stmt = $conn->prepare("SELECT id_user, rm, nome, pontos FROM users ORDER BY pontos DESC");
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
        <h1 class="text-xl font-bold mb-5">Consulta de Usuários</h1>
        <table class="w-full max-w-screen-md text-sm text-left text-gray-800">
            <thead class="text-x text-gray-100 bg-blue-500">
                <tr>
                    <th scope="col" class="px-2 py-3">RM</th>
                    <th scope="col" class="px-3 py-3">Nome</th>
                    <th scope="col" class="px-3 py-3">Pontos</th>
                    <th scope="col" class="px-6 py-3">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dados as $aluno) { ?>
                <tr class="bg-white border-b dark:border-gray-700">
                    <td class="px-2 py-4"><?php echo $aluno["rm"];?></td>
                    <td class="px-3 py-4"><?php echo $aluno["nome"];?></td>
                    <td class="px-3 py-4"><?php echo $aluno["pontos"];?></td>
                    <td class="px-6 py-4">
                        <a href="<?php echo "/admin/usuarios/atualiza?id_user=".$aluno["id_user"] ?>">
                            <i class="fa fa-edit mr-2 hover:text-blue-500 transition-all" aria-hidden="true"></i>
                        </a>
                        <a href="<?php echo "/api/delete_user?id_user=".$aluno["id_user"] ?>">
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