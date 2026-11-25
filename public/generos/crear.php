<?php
use App\Bd\Genero;
use App\Utils\Navegacion;
use App\Utils\Validacion;

session_start();
require __DIR__ . "/../../vendor/autoload.php";

if(!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 1){
    header("Location:./..");
    exit();
}

$nombre="";
$color="#FFFFFF";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nombre= Validacion::sanearCadena($_POST['nombre']);
    $color= Validacion::sanearCadena($_POST['color']);

    $errores=false;

    if(!Validacion::longitudCadenaValida('nombre', $nombre, 50, 3)){
        $errores=true;
    }else{
        if(Validacion::existeGenero($nombre)){
            $errores=true;
        }
    }

    if(!Validacion::colorValido($color)){
        $errores=true;
     }

    if(!$errores){
        (new Genero)
            ->setNombre($nombre)
            ->setColor($color)
            ->crear();
        $_SESSION['mensaje']="Genero guardado";
        header("Location:admin.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>     
<meta charset="UTF-8">     
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- CDN Tailwind css -->
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<!-- CDN Iconos FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg==" crossorigin="anonymous" referrerpolicy="no-referrer">
<link rel="stylesheet" href="https://unpkg.com/@constantine256/dialogx/dist/dialogx.css">
<script src="https://unpkg.com/@constantine256/dialogx/dist/dialogx.iife.js"></script>

<title>Géneros</title>

</head>
<body>

<?php Navegacion::pintarBarraNavegacion() ?>

<div class="mt-4 w-1/3 max-w-xl mx-auto bg-white p-8 rounded-xl shadow-md">

    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        <i class="fa-solid fa-palette mr-2 text-gray-600"></i>
        Crear género
    </h2>

    <form action="crear.php" method="POST">

        <!-- Nombre -->
        <div class="mb-5">

            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                Nombre
            </label>

            <div class="flex items-center border border-gray-300 rounded-lg px-3">
                <i class="fa-solid fa-tag text-gray-400"></i>

                <input type="text" id="nombre" name="nombre" value="<?= $nombre ?>"
                    class="w-full p-3 outline-none"
                    placeholder="Introduce el nombre">
            </div>

            <?php Validacion::pintarError('err_genero') ?>

        </div>

        <!-- Color -->
        <div class="mb-6">

            <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                Color
            </label>

            <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2">
                <i class="fa-solid fa-palette text-gray-400 mr-3"></i>

                <input type="color" id="color" name="color" value="<?= $color ?>"
                    class="w-full h-10 cursor-pointer">
            </div>

            <?php Validacion::pintarError('err_color') ?>

        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-3">

            <a href="admin.php"
                class="px-5 py-2.5 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                <i class="fa-solid fa-xmark mr-1"></i>
                Cancelar
            </a>

            <button type="submit"
                class="px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                <i class="fa-solid fa-check mr-1"></i>
                Enviar
            </button>

        </div>

    </form>

</div>
</body>
</html>
