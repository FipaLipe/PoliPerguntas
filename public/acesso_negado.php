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
            <img src="/public/assets/img/logo-politec.png" alt="logo-politec" class="w-44 justify-self-center mb-6">
            <h1 class="text-xl font-bold text-center mb-2 text-red-500">PoliPerguntas - Acesso</h1>

            <p class="text-xl font-regular text-center mb-5 text-red-500"> Não foi possível encontrar suas credenciais.
                Por favor se conecte novamente. </p>
            <br>
            <br>
            <br>
            <br>
            <a href="/login">
                <button class="transition-all duration-300 w-80 p-3 bg-blue-500 text-white font-semibold rounded-md text-lg
                    hover:bg-blue-600" type="submmit" name="btn-login" href="/login">
                    Login
                </button>
            </a>
        </div>
    </div>
</body>

</html>