<?php
include_once '../config/database.php';

$database = new Database();
$conn = $database->connect();

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'check_availability':
            $fecha_entrada = $_POST['fecha_entrada'];
            $fecha_salida = $_POST['fecha_salida'];
            $tipo_habitacion = $_POST['tipo_habitacion'] ?? '';  // Opcional: filtrar por tipo de habitación

            // Aseguramos que las fechas son recibidas
            if (!$fecha_entrada || !$fecha_salida) {
                $response['message'] = "Las fechas de entrada y salida son necesarias";
                break;
            }

            $query = "SELECT h.*, CONCAT('/hotel_ajax/img/habitacion', id_habitacion, '.jpg') AS imagen FROM Habitaciones h
                      WHERE h.estado = 'disponible'
                      AND (h.tipo_habitacion LIKE ? OR ? = '')
                      AND h.id_habitacion NOT IN (
                          SELECT r.id_habitacion FROM Reservas r WHERE
                          r.fecha_entrada <= ? AND r.fecha_salida >= ?
                      )";
            $stmt = $conn->prepare($query);
            $tipo_habitacion = "%{$tipo_habitacion}%";
            if ($stmt) {
                $stmt->bind_param("ssss", $tipo_habitacion, $tipo_habitacion, $fecha_salida, $fecha_entrada);
                $stmt->execute();
                $result = $stmt->get_result();
                $habitaciones = $result->fetch_all(MYSQLI_ASSOC);
                $response = ['success' => true, 'habitaciones' => $habitaciones];
                $stmt->close();
            } else {
                $response['message'] = 'Error al preparar la consulta de disponibilidad: ' . $conn->error;
            }
            break;
        
        default:
            $response['message'] = 'Acción no válida';
            break;
    }

    echo json_encode($response);
    $conn->close();
}
?>
