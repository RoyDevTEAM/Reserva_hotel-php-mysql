<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/hotel_ajax/js/procesaReserva.js"></script>
</head>
<body class="bg-gray-100">
    <?php include_once '../template_cliente/header.php'; ?>

    <div class="container mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold text-center mb-6">Detalles de tu Reserva</h1>
        
        <div class="bg-white p-8 border border-gray-200 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold">Información de la Habitación</h2>
            <p>Tipo de habitación: <?= htmlspecialchars($_GET['tipo_habitacion'] ?? 'No especificado') ?></p>
            <p>Fecha de entrada: <?= htmlspecialchars($_GET['fecha_entrada'] ?? 'No especificado') ?></p>
            <p>Fecha de salida: <?= htmlspecialchars($_GET['fecha_salida'] ?? 'No especificado') ?></p>
            <p>Costo total inicial: $<span id="display_costo_total"><?= htmlspecialchars($_GET['costo_total'] ?? '0') ?></span></p>

            <form id="addServiceForm" class="mt-6">
            <input type="hidden" id="id_reserva" name="id_reserva" value="<?= htmlspecialchars($_GET['id_reserva'] ?? '') ?>">
            <label for="id_servicio" class="block text-gray-700 text-sm font-bold mb-2">Añadir Servicio:</label>
            <select id="id_servicio" name="id_servicio" class="mb-4 p-2 w-full border rounded">
                <!-- Las opciones se cargan dinámicamente mediante JS -->
            </select>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Añadir Servicio</button>
        </form>
    </div>

    <div class="mt-8">
        <form id="finalizeReservationForm">
            <input type="hidden" id="id_reserva" name="id_reserva" value="<?= htmlspecialchars($_GET['id_reserva'] ?? '') ?>">
            <label for="metodo_pago" class="block text-gray-700 text-sm font-bold mb-2">Método de Pago:</label>
            <select id="metodo_pago" name="metodo_pago" class="mb-4 p-2 w-full border rounded">
                <!-- Las opciones se cargan dinámicamente mediante JS -->
            </select>
            <!-- Input para manejar el monto total de la reserva -->
            <input type="hidden" id="monto" name="monto" value="<?= htmlspecialchars($_GET['costo_total'] ?? '0') ?>">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Finalizar Reserva</button>
        </form>
    </div>
</div>

<?php include_once '../template_cliente/footer.php'; ?>
<script>
    $(document).ready(function() {
        loadServices();
        loadPaymentMethods();
    });
</script>
</body>
</html>
