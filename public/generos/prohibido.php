<?php
 http_response_code(403);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 403 - Acceso denegado</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-10 rounded-xl shadow-lg text-center max-w-md w-full mx-4">

        <div class="text-red-500 text-7xl font-bold mb-4">
            403
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-3">
            Acceso denegado
        </h1>

        <p class="text-gray-500 mb-8">
            No tienes permisos para acceder a esta página.
        </p>

        <a href="admin.php"
           class="inline-block bg-gray-800 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition">
            Volver al inicio
        </a>

    </div>

</body>
</html>
