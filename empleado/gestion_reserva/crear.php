<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>Crear Reserva</title>
</head>
<body class="bg-gray-100">
<?php include_once '../../template/header.php'; ?>

    <div class="container mx-auto px-4 py-5">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-10">Crear Reserva</h1>

        <div class="flex flex-wrap -mx-4 justify-center">
            <!-- Formulario de reserva -->
            <div class="w-full lg:w-1/2 px-4 mb-6">
                <div class="bg-white shadow-xl rounded-lg p-6">
                    <!-- Búsqueda de Cliente -->
                    <div class="mb-6">
                        <label for="inputCliente" class="block text-sm font-medium text-gray-700">Buscar Cliente:</label>
                        <input type="text" id="inputCliente" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" placeholder="Nombre del cliente">
                    </div>

                    <!-- Selección de Fechas -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="fechaEntrada" class="block text-sm font-medium text-gray-700">Fecha de Entrada:</label>
                            <input type="date" id="fechaEntrada" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="fechaSalida" class="block text-sm font-medium text-gray-700">Fecha de Salida:</label>
                            <input type="date" id="fechaSalida" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                    </div>

                    <!-- Tipo de Habitación -->
                    <div class="mb-6">
                        <label for="tipoHabitacion" class="block text-sm font-medium text-gray-700">Tipo de Habitación:</label>
                        <select id="tipoHabitacion" disabled class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500">
                            <option>Seleccione una habitación</option>
                        </select>
                    </div>

                    <!-- Servicios Extras -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Servicios Extras:</label>
                        <div id="serviciosExtras" class="mt-2 space-y-2">
                            <!-- Los servicios se cargarán aquí por JavaScript -->
                        </div>
                        <button id="btnSumarServicios" class="mt-3 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Sumar Servicios al Costo Total</button>
                    </div>

                    <!-- Método de Pago -->
                    <div class="mb-6">
                        <label for="metodoPago" class="block text-sm font-medium text-gray-700">Método de Pago:</label>
                        <select id="metodoPago" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500">
                            <!-- Los métodos de pago se cargarán aquí por JavaScript -->
                        </select>
                    </div>

                    <button id="btnReservar" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Crear Reserva</button>
                </div>
            </div>

            <!-- Card de Resumen de Reserva -->
            <div class="w-full lg:w-1/2 px-4">
                <div class="bg-white shadow-xl rounded-lg p-6">
                    <h2 class="text-xl font-bold mb-4">Resumen de la Reserva</h2>
                    <p id="resumenCliente" class="text-gray-700 mb-2">Cliente: <span></span></p>
                    <p id="resumenFechas" class="text-gray-700 mb-2">Fecha de Entrada/Salida: <span></span></p>
                    <p id="resumenHabitacion" class="text-gray-700 mb-2">Habitación: <span></span></p>
                    <p id="resumenServicios" class="text-gray-700 mb-2">Servicios Extras: <span></span></p>
                    <p id="resumenPago" class="text-gray-700 mb-2">Método de Pago: <span></span></p>
                    <p id="costoTotal" class="text-lg font-semibold">Costo Total: $0</p>
                </div>
            </div>
        </div>
    </div>

    <script src="../../js/procesaReservaadmin.js"></script>
    <script>
       
    </script>
</body>
</html>
