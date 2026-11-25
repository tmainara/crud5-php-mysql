<?php

use App\Bd\Usuario;
use App\Utils\Validacion;

session_start();
require __DIR__ . "/../vendor/autoload.php";

$email="";
if($_SERVER['REQUEST_METHOD']=='POST'){
    $email= Validacion::sanearCadena($_POST['email']);
    $password= Validacion::sanearCadena($_POST['password']);

    $perfil= Validacion::loginValido($email, $password);
    
    if($perfil != -1){
        session_regenerate_id(true);
        $_SESSION['email']=$email;
        $_SESSION['perfil']=$perfil;
        header("Location:libros/admin.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Biblioteca</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">

        <h1 class="text-3xl font-bold text-center mb-6">
            Biblioteca
        </h1>

        <form action="login.php" method="POST">

            <div class="mb-4">
                <label for="email" class="block mb-2 font-medium">
                    Email
                </label>

                <input type="email" name="email" id="email"
                    class="w-full border rounded-lg p-3"
                    placeholder="Introduce tu email"
                    value="<?= $email ?>"
                    required>
            </div>

            <div class="mb-6">
                <label for="password" class="block mb-2 font-medium">
                    Contraseña
                </label>

                <input type="password" name="password" id="password"
                    class="w-full border rounded-lg p-3"
                    placeholder="Introduce tu contraseña"
                    required>
            </div>
            <?php Validacion::pintarError('err_login') ?>

            <button type="submit"
                class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700">
                Iniciar sesión
            </button>

        </form>

    </div>

</body>

</html>