<?php

use App\Bd\Genero;
use App\Bd\Libro;
use App\Bd\Usuario;
use App\Utils\Navegacion;
use App\Utils\Validacion;

session_start();
require __DIR__ . "/../../vendor/autoload.php";

if (!isset($_SESSION['email'])) {
    header("Location:../login.php");
    exit();
}
$generos = Genero::getGeneros();
$titulo = "";
$sinopsis = "";
$disponible = "No";
$genero_id = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = Validacion::sanearCadena($_POST['titulo']);
    $sinopsis = Validacion::sanearCadena($_POST['sinopsis']);
    $disponible = $_POST['disponible'] ?? "error";
    $disponible = Validacion::sanearCadena($_POST['disponible']);
    $genero_id = (int) $_POST['genero_id'];

    $errores = false;
    if (!Validacion::longitudCadenaValida('titulo', $titulo, 200, 1)) {
        $errores = true;
    }
    if (!Validacion::longitudCadenaValida('sinopsis', $sinopsis, 1000, 1)) {
        $errores = true;
    }
    if (!Validacion::generoValido($genero_id)) {
        $errores = true;
    }
    if (!Validacion::disponibleValido($disponible)) {
        $errores = true;
    }

    $portada = '/imagenes/default.jpg';
    if (is_uploaded_file($_FILES['portada']['tmp_name'])) {
        $file = $_FILES['portada'];
        if (Validacion::imagenValida($file['type'], $file['size'])) {
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $portada = "/imagenes/" . uniqid() . ".$extension";

            if (!move_uploaded_file($file['tmp_name'], "./..$portada")) {
                $_SESSION['err_img'] = "ERROR, no se pudo guardar la imagen";
                $errores = true;
            }
        } else {
            $errores = true;
        }
    }

    if (!$errores) {
        $user_id = Usuario::getUserIdByEmail($_SESSION['email']);
        (new Libro)
            ->setTitulo($titulo)
            ->setSinopsis($sinopsis)
            ->setGenero_id($genero_id)
            ->setDisponible($disponible)
            ->setPortada($portada)
            ->setUsuario_id($user_id)
            ->crear();
        $_SESSION['mensaje'] = "Libro creado correctamente";
        header("Location:admin.php");
        exit();
    }
}
$ckSi = ($disponible == 'Si') ? "selected" : "";
$ckNo = ($disponible == 'No') ? "selected" : "";
?>


<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <title>Añadir libro - Biblioteca\</title>
</head>

<body class="bg-gray-100 min-h-screen">
    <?php Navegacion::pintarBarraNavegacion() ?>

    <main class="max-w-3xl mx-auto px-4 py-10">

        <div class="bg-white rounded-lg shadow p-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">
                    Añadir libro
                </h1>

                <p class="text-gray-500 mt-2">
                    Completa los datos para añadir un nuevo libro a tu biblioteca.
                </p>
            </div>

            <form action="crear.php" method="POST" enctype="multipart/form-data">

                <!-- Título -->
                <div class="mb-5">
                    <label for="titulo" class="block font-medium text-gray-700 mb-2">
                        Título
                    </label>

                    <input type="text" name="titulo" id="titulo"
                        placeholder="Introduce el título del libro"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-indigo-500"
                        value="<?= $titulo ?>"
                        required>
                    <?php Validacion::pintarError('err_titulo') ?>
                </div>

                <!-- Sinopsis -->
                <div class="mb-5">
                    <label for="sinopsis" class="block font-medium text-gray-700 mb-2">
                        Sinopsis
                    </label>

                    <textarea name="sinopsis" id="sinopsis" rows="5"
                        placeholder="Escribe una breve descripción del libro..."
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-indigo-500"
                        required><?= $sinopsis ?></textarea>
                    <?php Validacion::pintarError('err_sinopsis') ?>
                </div>

                <!-- Disponibilidad -->
                <div class="mb-5">
                    <label for="disponible" class="block font-medium text-gray-700 mb-2">
                        Disponibilidad
                    </label>

                    <select name="disponible" id="disponible"
                        class="w-full border border-gray-300 rounded-lg p-3"
                        required>

                        <option value="Si" <?= $ckSi ?>>Disponible</option>
                        <option value="No" <?= $ckNo ?>>No disponible</option>

                    </select>
                    <?php Validacion::pintarError('err_disponible'); ?>
                </div>

                <!-- Género -->
                <div class="mb-5">
                    <label for="genero_id" class="block font-medium text-gray-700 mb-2">
                        Género
                    </label>

                    <select name="genero_id" id="genero_id"
                        class="w-full border border-gray-300 rounded-lg p-3"
                        required>
                        <?php foreach ($generos as $genero):
                            $selected = ($genero == $genero_id) ? "selected" : "";
                        ?>
                            <option value="<?= $genero->id ?>" <?= $selected ?>><?= $genero->nombre ?></option>
                        <?php endforeach; ?>

                    </select>
                    <?php Validacion::pintarError('err_genero'); ?>
                </div>

                <!-- Portada -->
                <label for="" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-image text-indigo-500 mr-2"></i>
                    Portada del libro
                </label>

                <div class="w-full h-96 rounded bg-blue-100 relative">
                    <input type="file" name="portada" accept="image/*" id="nimagen" class="hidden" />

                    <label for="nimagen" class="absolute bottom-2 right-2 rounded-lg p-2 text-white bg-black font-semibold cursor-pointer">
                        <i class="fa-solid fa-upload mr-2"></i>SUBIR
                    </label>

                    <img src="" class="w-full h-full object-cover rounded" id="preview" />
                </div>

                <?php Validacion::pintarError('err_img'); ?>

                <!-- Botones -->
                <div class="flex flex-col sm:flex-row justify-end gap-3 border-t border-gray-100 pt-6">

                    <a
                        href="admin.php"
                        class="px-6 py-3 rounded-lg border border-gray-300 text-gray-600 font-semibold text-center hover:bg-gray-100 transition">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 shadow-md shadow-indigo-200 transition">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Guardar libro
                    </button>

                </div>

            </form>

        </div>

    </main>
    <script>
        const input = document.getElementById('nimagen');
        const preview = document.getElementById('preview');

        input.addEventListener('change', function() {
            const reader = new FileReader();

            reader.onload = function() {
                preview.src = reader.result;
            };

            reader.readAsDataURL(input.files[0]);
        });
    </script>
</body>

</html>