<?php
include_once '../config/database.php';  // Asegúrate de que la ruta es correcta.

$database = new Database();
$conn = $database->connect();

$id_reserva = isset($_GET['id_reserva']) ? intval($_GET['id_reserva']) : 0;

if ($id_reserva > 0) {
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

    $stmt->close();
    $stmtServicios->close();
    $conn->close();

    // Pasar datos a la vista (puede ser JSON o simplemente asignar a variables de PHP para usar en el mismo script)
    header('Content-Type: application/json');
    echo json_encode($reserva);
} else {
    echo json_encode(['error' => 'ID de reserva no válido']);
}
?>
