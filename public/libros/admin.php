<?php

use App\Bd\Libro;
use App\Bd\Usuario;
use App\Utils\Navegacion;
use Carbon\Carbon;

session_start();
require __DIR__ . "/../../vendor/autoload.php";

if (!isset($_SESSION['email'])) {
    header("Location:../login.php");
    exit();
}

$userId = Usuario::getUserIdByEmail($_SESSION['email']);
$libros = Libro::getLibrosUsuario($userId);
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

    <title>Administración de libros</title>
</head>

<body class="bg-gray-100 min-h-screen">
    <?php Navegacion::pintarBarraNavegacion() ?>

    <main class="max-w-7xl mx-auto px-4 py-10">

        <div class="flex justify-between items-center mb-6">

            <h1 class="text-3xl font-bold text-gray-800">
                Mis libros
            </h1>

            <a href="crear.php"
                class="px-6 py-3 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 shadow-md shadow-indigo-200 transition">
                <i class="fas fa-plus-circle mr-2"></i>
                Crear libro
            </a>

        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">

            <table class="w-full text-left">

                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-4">ID</th>
                        <th class="p-4">Portada</th>
                        <th class="p-4">Título</th>
                        <th class="p-4">Género</th>
                        <th class="p-4">Disponible</th>
                        <th class="p-4">Creado</th>
                        <th class="p-4">Última edición</th>
                        <th class="p-4">Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($libros as $libro): ?>

                        <tr class="border-t">
                            <td class="p-4"><?= $libro->id ?></td>
                            <td class="p-4">
                                <img src="./..<?= $libro->portada ?>"
                                    alt="Portada de <?= $libro->titulo ?>"
                                    class="w-16 h-20 object-cover rounded">
                            </td>
                            <td class="p-4"><?= $libro->titulo ?></td>
                            <td class="p-4"><?= $libro->genero ?></td>
                            <td class="p-4"><?= $libro->disponible ?></td>
                            <td class="p-4">
                                <?= Carbon::parse($libro->created_at)->format('d/m/Y H:i') ?>
                            </td>

                            <td class="p-4">
                                <?= Carbon::parse($libro->updated_at)->format('d/m/Y H:i') ?>
                            </td>
                            <td class="px-5 py-4">
                                <form action="borrar.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $libro->id ?>">

                                    <div class="flex items-center justify-center gap-3">

                                        <a href="editar.php?id=<?= $libro->id ?>"
                                            title="Editar libro"
                                            class="text-indigo-600 hover:text-indigo-800 transition">
                                            <i class="fas fa-edit text-lg"></i>
                                        </a>

                                        <button type="submit" onclick="confirm('¿BORRAR PERMANENTEMENTE?')"
                                            title="Eliminar libro"
                                            class="text-red-500 hover:text-red-700 transition">
                                            <i class="fas fa-trash-alt text-lg"></i>
                                        </button>

                                    </div>
                                </form>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </main>

</body>

</html>