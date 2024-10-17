<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div id="main" class="w-full h-screen bg-zinc-100 flex items-top justify-center p-10">
        <div id="login" class="p-5 w-fit flex flex-col items-center">
            <img src="assets/img/logo-politec.png" alt="logo-politec" class="w-44 justify-self-center mb-6">
            <h1 class="text-xl font-regular text-center mb-5">PoliPerguntas - Acesso</h1>
            <form id="form_login" class="flex flex-col">
                <input type="text" name="rm" placeholder="RM" class="border-2 rounded-t-lg w-80 h-14 p-4">
                <input type="text" name="senha" placeholder="Senha" class="border-2 rounded-b-lg w-80 h-14 p-4">
                <br>
                <button
                    class="transition-all duration-300 w-80 p-3 bg-blue-500 text-white font-semibold rounded-md text-lg hover:bg-blue-600"
                    type="submmit" name="btn-login">Login</button>
                <div class="flex items-end justify-between"><a
                        class="text-blue-500 hover:text-blue-600 mt-2 underline decoration-solid text-center cursor-pointer"
                        href="#">Quero me cadastrar</a> | <a
                        class="text-blue-500 hover:text-blue-600 mt-2 underline decoration-solid text-center cursor-pointer"
                        href="#">Esqueceu a senha?</a></div>

            </form>
        </div>
    </div>

    <script>
    </script>
</body>

</html>