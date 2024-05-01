<?php
include_once '../../functions/checkSesion.php';
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Habitaciones</title>
    <!-- Incluir Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Incluir Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body class="bg-gray-100">
<?php include_once '../../template/header.php'; ?>

    <div class="container mx-auto p-4">
        <!-- Botón para agregar habitación -->
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4" onclick="location.href='crear.php'">
            <i class="fas fa-plus mr-2"></i>Añadir Habitación
        </button>

        <!-- Búsqueda -->
        <div class="mb-4">
            <input type="text" id="searchBox" class="form-input mt-1 block w-full p-2 border border-gray-300 rounded" placeholder="Buscar por número o tipo...">
        </div>

        <!-- Tabla para mostrar habitaciones -->
        <div id="habitacionesContainer" class="bg-white shadow-md rounded my-6">
            <!-- Las habitaciones se cargarán aquí mediante AJAX -->
        </div>

        <!-- Paginación -->
        <div id="pagination" class="mt-5">
            <!-- Los botones de paginación se cargarán aquí mediante AJAX -->
        </div>
    </div>

    <!-- Incluir script de AJAX y script personalizado -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../../js/habitacion.js"></script>
</body>
</html>