<?php
include_once '../config/database.php';
$database = new Database();
$conn = $database->connect();

// Capturar el tipo de reporte requerido
$reporteTipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'ocupacion';

header('Content-Type: application/json'); // Asegura que la respuesta es tipo JSON

// Preparar y enviar respuesta según el tipo de reporte
switch ($reporteTipo) {
    case 'ocupacion':
        echo json_encode(['data' => obtenerDatosOcupacion($conn)]);
        break;
    case 'ingresos':
        echo json_encode(['data' => obtenerDatosIngresos($conn)]);
        break;
    case 'servicios':
        echo json_encode(['data' => obtenerDatosServicios($conn)]);
        break;
    case 'metodosPago':
        echo json_encode(['data' => obtenerDatosMetodosPago($conn)]);
        break;
    default:
        echo json_encode(["error" => "Tipo de reporte no especificado"]);
        break;
}

function obtenerDatosOcupacion($conn) {
    $query = "SELECT tipo_habitacion, COUNT(*) AS cantidad, estado FROM Habitaciones GROUP BY tipo_habitacion, estado";
    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = ['label' => $row['tipo_habitacion'] . ' - ' . $row['estado'], 'value' => (int)$row['cantidad']];
    }
    return $data;
}

function obtenerDatosIngresos($conn) {
    $query = "SELECT Habitaciones.tipo_habitacion, SUM(Reservas.costo_total) AS ingresos FROM Reservas
              JOIN Habitaciones ON Reservas.id_habitacion = Habitaciones.id_habitacion
              WHERE Reservas.estado_reserva = 'completada'
              GROUP BY Habitaciones.tipo_habitacion";
    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = ['label' => $row['tipo_habitacion'], 'value' => (float)$row['ingresos']];
    }
    return $data;
}

function obtenerDatosServicios($conn) {
    $query = "SELECT Servicios.nombre, COUNT(*) AS cantidad FROM Servicios
              JOIN Reserva_Servicios ON Servicios.id_servicio = Reserva_Servicios.id_servicio
              GROUP BY Servicios.nombre";
    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = ['label' => $row['nombre'], 'value' => (int)$row['cantidad']];
    }
    return $data;
}

function obtenerDatosMetodosPago($conn) {
    $query = "SELECT metodo_pago, COUNT(*) AS cantidad FROM Pagos
              GROUP BY metodo_pago";
    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = ['label' => $row['metodo_pago'], 'value' => (int)$row['cantidad']];
    }
    return $data;
}
?>
