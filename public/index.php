<?php

use App\Bd\Libro;
use App\Utils\Navegacion;
use Carbon\Carbon;
session_start();
require __DIR__ . "/../vendor/autoload.php"; 

$libros= Libro::getLibrosDisponibles();

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

<title>Biblioteca - Libros disponibles</title>

</head>

<body class="bg-gray-100 min-h-screen">

<?php Navegacion::pintarBarraNavegacion() ?>

<main class="max-w-7xl mx-auto px-4 py-10">

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Nuestra biblioteca
            </h1>

            <p class="text-gray-500 mt-2">
                Descubre todos los libros disponibles.
            </p>
        </div>

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
                </tr>
            </thead>

            <tbody>

                <?php foreach ($libros as $libro): ?>

                    <tr class="border-t">

                        <td class="p-4"><?= $libro->id ?></td>

                        <td class="p-4">
                            <img src="<?= ".$libro->portada" ?>"
                                alt="Portada de <?= $libro->titulo ?>"
                                class="w-16 h-20 object-cover rounded">
                        </td>

                        <td class="p-4"><?= $libro->titulo ?></td>

                        <td class="p-4"><?= $libro->genero ?></td>

                        <td class="p-4">
                            <span class="text-green-600 font-semibold">
                                <?= $libro->disponible ?>
                            </span>
                        </td>

                        <td class="p-4">
                            <?= Carbon::parse($libro->created_at)->diffForHumans() ?>
                        </td>

                        <td class="p-4">
                            <?= Carbon::parse($libro->updated_at)->diffForHumans() ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

        <?php if (count($libros) == 0): ?>

            <div class="text-center py-10 text-gray-500">
                <i class="fas fa-book-open text-4xl mb-3"></i>
                <p>No hay libros disponibles actualmente.</p>
            </div>

        <?php endif; ?>

    </div>

</main>

</body>

</html>