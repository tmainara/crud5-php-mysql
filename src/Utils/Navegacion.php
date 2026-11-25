<?php

namespace App\Utils;

abstract class Navegacion
{
    public static function pintarBarraNavegacion(): void
    {
        $localizacion = $_SERVER['PHP_SELF'];

        $ruta = "./cerrar.php";
        $enlace = "./libros/admin.php";
        $enlaceGeneros = "./generos/admin.php";
        $texto = "Gestionar Libros";

        if (str_contains($localizacion, 'libros') || str_contains($localizacion, 'generos')) {
            $ruta = "./../cerrar.php";
            $enlace = "./../";
            $enlaceGeneros = "./../generos/admin.php";
            $texto = "Inicio";
        }

        $color = "";

        if (isset($_SESSION['perfil'])) {
            $color = ($_SESSION['perfil'] == 1) ? "text-red-600" : "text-blue-600";
        }

        $user = $_SESSION['email'] ?? "";

        $userLogo = <<<TXT
            <div class="relative">
                <i class="fas fa-user-circle absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input
                    type="text"
                    value="$user"
                    readonly
                    class="w-52 pl-9 pr-3 py-2 text-sm $color bg-gray-50 border border-gray-200 rounded-lg focus:outline-none cursor-default"
                >
            </div>

            <a href="$ruta"
                class="flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition duration-200">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        TXT;

        $nologin = <<<TXT
            <a href="login.php"
                class="flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-lg transition duration-200">
                <i class="fas fa-sign-out-alt"></i>
                Login
            </a>
        TXT;

        $gestionGeneros = "";

        if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == 1) {
            $gestionGeneros = <<<TXT
                <a href="$enlaceGeneros"
                    class="flex items-center gap-2 px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white text-sm font-semibold rounded-lg transition duration-200">
                    <i class="fas fa-palette"></i>
                    Gestionar Géneros
                </a>
            TXT;
        }

        $cambios = (isset($_SESSION['email'])) ? $userLogo : $nologin;

        echo <<<TXT
        <nav class="bg-white border-b border-gray-200 shadow-sm px-6 py-3">
            <div class="max-w-7xl mx-auto flex items-center justify-between">

                <a href="$enlace" class="flex items-center gap-2 text-indigo-600 font-bold text-xl hover:text-indigo-800">
                    <i class="fas fa-book"></i>
                    <span>$texto</span>
                </a>

                <div class="flex items-center gap-3">
                    $gestionGeneros
                    $cambios
                </div>

            </div>
        </nav>
        TXT;
    }
}