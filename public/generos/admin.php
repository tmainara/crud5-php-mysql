<?php

use App\Bd\Genero;
use App\Utils\Navegacion;

session_start();
require __DIR__ . "/../../vendor/autoload.php";

if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 1) {
    header("Location:./..");
    exit();
}
$generos = Genero::getGeneros();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CDN Tailwind css -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- CDN Iconos FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQzg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://unpkg.com/@constantine256/dialogx/dist/dialogx.css">
    <script src="https://unpkg.com/@constantine256/dialogx/dist/dialogx.iife.js"></script>

    <title>Géneros</title>
</head>

<body>

    <?php Navegacion::pintarBarraNavegacion() ?>

    <main class="max-w-7xl mx-auto px-4 py-10">

        <div class="flex flex-row-reverse mb-4">
            <a href="crear.php" class="p-2 rounded-lg text-white font-semibold bg-green-500 hover:bg-green-700">
                <i class="fas fa-add mr-2"></i>Nuevo género
            </a>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow">

            <table class="w-full text-left text-sm text-gray-600">

                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Nombre</th>
                        <th class="px-6 py-4">Color</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">

                    <?php foreach ($generos as $item): ?>

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4"><?= $item->id ?></td>

                            <td class="px-6 py-4 font-medium text-gray-800">
                                <?= $item->nombre ?>
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-block bg-[<?= $item->color ?>] text-white px-4 py-2 rounded-full text-xs font-semibold">
                                    <?= $item->color ?>
                                </span>
                            </td>

                            <td class="px-6 py-4">

                                <form action="borrar.php" method="POST">

                                    <input type="hidden" name="id" value="<?= $item->id ?>">

                                    <div class="flex justify-center gap-3">

                                        <a href="editar.php?id=<?= $item->id ?>"
                                            class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm">
                                            <i class="fa-solid fa-pen-to-square mr-1"></i> Editar
                                        </a>

                                        <button type="submit"
                                            onclick="return confirm('¿Borrar definitivamente?')"
                                            class="bg-red-500 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm">
                                            <i class="fa-solid fa-trash mr-1"></i> Borrar
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

<?php
if (isset($_SESSION['mensaje'])) {
    echo "<script>
                Dialogx.notify.success('{$_SESSION['mensaje']}');
            </script>";
    unset($_SESSION['mensaje']);
}
?>

</html>