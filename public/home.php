<?php

require_once(__DIR__ . "/../utils/seguranca.php");
require_once(__DIR__ . "/../utils/conexao.php");
require_once(__DIR__ . "/../utils/get_perguntas_abertas.php");
require_once(__DIR__ . "/../utils/get_alternativas.php");
require_once(__DIR__ . "/../utils/get_ranking.php");

$perguntas = getPerguntasAbertas();

$ranking = getRanking();

?>


<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>PoliPerguntas</title>
</head>

<body>
    <div id="main" class="w-full h-screen bg-zinc-100 flex items-top justify-center p-10">
        <div id="perguntas" class="p-5 w-fit flex flex-col items-center">
            <img src="/public/assets/img/logo-politec.png" alt="logo-politec" class="w-44 justify-self-center mb-6">
            <h1 class="text-xl font-regular text-center mb-5">PoliPerguntas - Perguntas Abertas</h1>
            <?php
            $stmt = $conn->prepare("SELECT id_alternativa FROM respostas WHERE (id_pergunta = :id_pergunta) AND (id_user = (SELECT id_user from users WHERE rm = :rm))");
            $stmt->bindParam('rm', $_SESSION['user']);


            foreach ($perguntas as $pergunta) {
                $alternativas = getAlternativas($pergunta['id_pergunta']);

                $stmt->bindParam('id_pergunta', $pergunta['id_pergunta']);
                $stmt->execute();
                $alt_respondida = $stmt->fetchColumn();

                ?>

                <div class="bg-zinc-100 border-blue-500 border-2 rounded-lg p-6 mb-6 flex-col flex w-full">
                    <p class="text-lg mb-4"><?php echo $pergunta['texto'] ?></p>
                    <?php foreach ($alternativas as $alternativa) {
                        if (empty($alt_respondida)) { ?>
                            <a class="w-full bg-zinc-100 border-blue-500 border-2 rounded-lg p-2 mb-2 hover:bg-blue-200"
                                href="/api/responde?id_user=<?php echo $_SESSION['user'] . '&id_pergunta=' . $pergunta['id_pergunta'] . '&id_alternativa=' . $alternativa['id_alternativa'] ?>"><?php echo $alternativa['texto'] ?></a>
                        <?php } else { ?>
                            <div
                                class="w-full border-blue-500  rounded-lg p-2 mb-2 <?php echo $alt_respondida == $alternativa['id_alternativa'] ? 'border-2' : '' ?> <?php echo $alternativa['correta'] ? 'bg-green-200' : 'bg-red-200' ?>">
                                <?php echo $alternativa['texto'] ?>
                            </div>
                        <?php }
                    } ?>
                </div>
            <?php } ?>
        </div>

        <div id="ranking" class="p-5 w-fit flex flex-col items-center mt-20  border-blue-500 border-2 rounded-lg">
            <h1 class="text-xl font-regular text-center mb-5">Ranking de Alunos</h1>
            <?php foreach ($ranking as $user) { ?>
                <div class="w-full bg-blue-100 rounded-lg p-2 mb-2 hover:bg-blue-200">
                    <?php echo $user['pontos'] . '-' . $user['nome'] ?>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>