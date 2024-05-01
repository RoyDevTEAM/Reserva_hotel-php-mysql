<?php
include_once '../../functions/checkSesion.php';
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Habitación</title>
    <!-- Incluir Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Incluir Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Incluir jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Incluir script personalizado -->
    <script src="../../js/habitacion.js"></script>
</head>
<body class="bg-gray-100">
<?php include_once '../../template/header.php'; ?>


    <div class="container mx-auto px-4 py-12">
        <h1 class="text-2xl font-semibold mb-6">Crear Nueva Habitación</h1>
        <form id="formCrearHabitacion" method="POST" class="max-w-4xl mx-auto bg-white p-8 shadow rounded">
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="numero">
                        Número de Habitación
                    </label>
                    <input type="text" name="numero" id="numero" placeholder="101" required class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="tipo_habitacion">
                        Tipo de Habitación
                    </label>
                    <input type="text" name="tipo_habitacion" id="tipo_habitacion" placeholder="Ejemplo: Suite" required class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="descripcion">
                        Descripción
                    </label>
                    <textarea name="descripcion" id="descripcion" rows="3" placeholder="Describa la habitación..." class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"></textarea>
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="capacidad">
                        Capacidad
                    </label>
                    <input type="number" name="capacidad" id="capacidad" placeholder="2" required class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="precio_noche">
                        Precio por Noche ($)
                    </label>
                    <input type="text" name="precio_noche" id="precio_noche" placeholder="100.00" required class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="estado">
                        Estado
                    </label>
                    <select name="estado" id="estado" required class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <option value="disponible">Disponible</option>
                        <option value="ocupada">Ocupada</option>
                        <option value="mantenimiento">En Mantenimiento</option>
                        <option value="limpieza">En Limpieza</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Crear Habitación
                </button>
            </div>
        </form>
    </div>
</body>
</html>
