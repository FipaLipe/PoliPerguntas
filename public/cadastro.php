<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../utils/form_json.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div id="main" class="w-full h-screen bg-zinc-100 flex items-top justify-center p-10">
        <div id="login" class="p-5 w-fit flex flex-col items-center">
            <img src="assets/img/logo-politec.png" alt="logo-politec" class="w-44 justify-self-center mb-6">
            <h1 class="text-xl font-regular text-center mb-5">PoliPerguntas - Acesso</h1>
            <form id="form_cadastro" class="flex flex-col">
                <input type="text" name="rm" placeholder="RM" class="border-2 rounded-t-lg w-80 h-14 p-4">
                <input type="text" name="nome" placeholder="Nome" class="border-2 w-80 h-14 p-4 rounded-b-lg">
                <br>
                <input type="text" name="senha" placeholder="Senha" class="border-2 rounded-t-lg w-80 h-14 p-4">
                <input type="text" name="senha" placeholder="Confirme a senha"
                    class="border-2 rounded-b-lg w-80 h-14 p-4">
                <br>
                <button
                    class="transition-all duration-300 w-80 p-3 bg-blue-500 text-white font-semibold rounded-md text-lg hover:bg-blue-600"
                    type="submmit" name="btn-cadastro">Cadastrar</button>
                <a class="text-blue-500 hover:text-blue-600 mt-2 underline decoration-solid text-center cursor-pointer"
                    href="#">Já tenho uma conta</a>
            </form>
        </div>
    </div>
    
    <script>
        document.getElementById('form_cadastro').addEventListener('submit', async (e) => {
            e.preventDefault();

            server_response = await form_json(event.target, 'add_user.php');
        });
    </script>
</body>

</html>