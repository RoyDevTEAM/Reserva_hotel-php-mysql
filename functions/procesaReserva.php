<?php
include_once '../config/database.php';

$database = new Database();
$conn = $database->connect();

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'crear_reserva':
            $id_usuario = $_POST['id_usuario'];
            $id_habitacion = $_POST['id_habitacion'];
            $fecha_entrada = $_POST['fecha_entrada'];
            $fecha_salida = $_POST['fecha_salida'];
            $costo_total = $_POST['costo_total'];

            $query = "INSERT INTO Reservas (id_usuario, id_habitacion, fecha_entrada, fecha_salida, costo_total, estado_reserva) VALUES (?, ?, ?, ?, ?, 'pendiente')";
            $stmt = $conn->prepare($query);
            if ($stmt) {
                $stmt->bind_param("iissd", $id_usuario, $id_habitacion, $fecha_entrada, $fecha_salida, $costo_total);
                if ($stmt->execute()) {
                    $response = ['success' => true, 'message' => 'Reserva creada con éxito', 'id_reserva' => $conn->insert_id];
                } else {
                    $response['message'] = 'Error al crear la reserva: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                $response['message'] = 'Error al preparar la consulta';
            }
            break;

        case 'add_service_to_reservation':
            $id_reserva = $_POST['id_reserva'];
            $id_servicio = $_POST['id_servicio'];

            // Obtener el precio del servicio
            $stmtService = $conn->prepare("SELECT precio FROM Servicios WHERE id_servicio = ?");
            $stmtService->bind_param("i", $id_servicio);
            $stmtService->execute();
            $resultService = $stmtService->get_result();
            $service = $resultService->fetch_assoc();

            // Obtener el costo total actual de la reserva
            $stmtReserva = $conn->prepare("SELECT costo_total FROM Reservas WHERE id_reserva = ?");
            $stmtReserva->bind_param("i", $id_reserva);
            $stmtReserva->execute();
            $resultReserva = $stmtReserva->get_result();
            $reserva = $resultReserva->fetch_assoc();

            $nuevo_costo_total = $reserva['costo_total'] + $service['precio'];

            // Actualizar la reserva con el nuevo costo total
            $stmtUpdate = $conn->prepare("UPDATE Reservas SET costo_total = ? WHERE id_reserva = ?");
            $stmtUpdate->bind_param("di", $nuevo_costo_total, $id_reserva);
            if ($stmtUpdate->execute()) {
                $response = ['success' => true, 'message' => 'Servicio añadido y reserva actualizada correctamente', 'nuevo_costo_total' => $nuevo_costo_total];
            } else {
                $response['message'] = 'Error al actualizar la reserva: ' . $stmtUpdate->error;
            }
            $stmtUpdate->close();
            $stmtReserva->close();
            $stmtService->close();
            break;

        case 'finalize_reservation':
            $id_reserva = $_POST['id_reserva'];
            $metodo_pago = $_POST['metodo_pago'];
            $monto = $_POST['monto'];

            $queryPago = "INSERT INTO Pagos (id_reserva, fecha_pago, monto, metodo_pago, estado_pago) VALUES (?, NOW(), ?, ?, 'pendiente')";
            $stmtPago = $conn->prepare($queryPago);
            $stmtPago->bind_param("ids", $id_reserva, $monto, $metodo_pago);
            if ($stmtPago->execute()) {
                $response = ['success' => true, 'message' => 'Pago procesado y reserva finalizada correctamente'];
            } else {
                $response['message'] = 'Error al procesar el pago: ' . $stmtPago->error;
            }
            $stmtPago->close();
            break;

        default:
            $response['message'] = 'Acción no válida';
            break;
    }

    echo json_encode($response);
    $conn->close();
}
?>
