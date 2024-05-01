<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Habitación</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body class="bg-gray-100">
    <?php include_once '../template_cliente/header.php'; ?>

    <div class="container mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold text-center mb-6">Reserva tu Habitación</h1>

        <div class="w-full max-w-4xl mx-auto bg-white p-8 border border-gray-200 rounded-lg">
            <form id="checkAvailabilityForm" class="mb-6">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label for="fecha_entrada" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Entrada:</label>
                        <input type="date" id="fecha_entrada" name="fecha_entrada" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label for="fecha_salida" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Salida:</label>
                        <input type="date" id="fecha_salida" name="fecha_salida" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0 flex items-end">
                        <button type="button" id="checkAvailabilityButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Verificar Disponibilidad
                        </button>
                    </div>
                </div>
            </form>

            <div id="availableRoomsContainer" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Aquí se mostrarán las habitaciones disponibles tras realizar la búsqueda -->
            </div>
        </div>
    </div>

    <?php include_once '../template_cliente/footer.php'; ?>
    <script src="/hotel_ajax/js/reservaCliente.js"></script>
</body>
</html>
