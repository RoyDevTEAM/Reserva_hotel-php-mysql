<?php
include_once '../../config/database.php';

$database = new Database();
$conn = $database->connect();

$id_reserva = isset($_GET['id_reserva']) ? intval($_GET['id_reserva']) : 0;
$reserva = null;

if ($id_reserva > 0) {
    // Prepara la consulta para obtener todos los detalles de la reserva
    $query = "SELECT Reservas.*, Usuarios.nombre AS cliente_nombre, Usuarios.apellido AS cliente_apellido,
              Habitaciones.numero AS habitacion_numero, Habitaciones.tipo_habitacion,
              Pagos.metodo_pago, Pagos.monto
              FROM Reservas
              JOIN Usuarios ON Reservas.id_usuario = Usuarios.id_usuario
              JOIN Habitaciones ON Reservas.id_habitacion = Habitaciones.id_habitacion
              JOIN Pagos ON Reservas.id_reserva = Pagos.id_reserva
              WHERE Reservas.id_reserva = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_reserva);
    $stmt->execute();
    $result = $stmt->get_result();
    $reserva = $result->fetch_assoc();

    // Obtener servicios adicionales
    $queryServicios = "SELECT Servicios.nombre
                       FROM Reserva_Servicios
                       JOIN Servicios ON Reserva_Servicios.id_servicio = Servicios.id_servicio
                       WHERE Reserva_Servicios.id_reserva = ?";
    $stmtServicios = $conn->prepare($queryServicios);
    $stmtServicios->bind_param("i", $id_reserva);
    $stmtServicios->execute();
    $resultServicios = $stmtServicios->get_result();
    $servicios = [];
    while ($row = $resultServicios->fetch_assoc()) {
        $servicios[] = $row['nombre'];
    }

    $reserva['servicios'] = $servicios;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de la Reserva</title>
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>   
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
</head>
<body class="bg-gray-100">
    <div id="print-section" class="container mx-auto px-4 py-10">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Detalle de la Reserva</h1>
                <img src="https://i.pinimg.com/736x/10/ff/aa/10ffaadab6bc3c4c1dd4a3e44bf6d5ad.jpg" alt="Logo de la Empresa" style="height: 50px;">
            </div>
            <div class="border-b-2 border-gray-200 mb-6"></div>
            
            <!-- Detalle del cliente -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Datos del Cliente</h2>
                <p><strong>Nombre:</strong> <?= $reserva['cliente_nombre'] . ' ' . $reserva['cliente_apellido'] ?></p>
            </div>

            <!-- Detalles de la reserva -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Información de la Reserva</h2>
                <p><strong>Fecha de Entrada:</strong> <?= $reserva['fecha_entrada'] ?></p>
                <p><strong>Fecha de Salida:</strong> <?= $reserva['fecha_salida'] ?></p>
                <p><strong>Tipo de Habitación:</strong> <?= $reserva['habitacion_numero'] . ' (' . $reserva['tipo_habitacion'] . ')' ?></p>
            </div>

            <!-- Servicios adicionales -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Servicios Adicionales</h2>
                <ul class="list-disc ml-5">
                    <?php foreach ($reserva['servicios'] as $servicio): ?>
                    <li><?= $servicio ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Pago y total -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Detalles del Pago</h2>
                <p><strong>Método de Pago:</strong> <?= $reserva['metodo_pago'] ?></p>
                <p><strong>Total a Pagar:</strong> $<?= number_format($reserva['monto'], 2) ?></p>
            </div>

            <!-- Botones de acción -->
            <div class="text-right">
                <button onclick="window.print();" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Imprimir
                </button>
            </div>
            <p class="text-center mt-10 text-gray-600">¡Gracias por su visita, vuelva pronto!</p>
        </div>
    </div>

    <script>
        // Configuración de Print.js para imprimir en orientación horizontal
        function printDocument() {
            printJS({
                printable: 'print-section',
                type: 'html',
                honorColor: true,
                targetStyles: ['*'],
                documentTitle: 'Factura Reserva - Hotel XYZ',
                style: '@page { size: landscape; }'
            });
        }
    </script>
</body>
</html>
