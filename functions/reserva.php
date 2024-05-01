<?php
include_once '../config/database.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action === 'create_reserva') {
        $id_usuario = $_POST['id_usuario'];
        $id_habitacion = $_POST['id_habitacion'];
        $fecha_entrada = $_POST['fecha_entrada'];
        $fecha_salida = $_POST['fecha_salida'];
        $costo_total = $_POST['costo_total'];
        $estado_reserva = $_POST['estado_reserva'];

        $query = "INSERT INTO Reservas (id_usuario, id_habitacion, fecha_entrada, fecha_salida, costo_total, estado_reserva) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iissds", $id_usuario, $id_habitacion, $fecha_entrada, $fecha_salida, $costo_total, $estado_reserva);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Reserva creada exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear la reserva: ' . $stmt->error]);
        }
        $stmt->close();
    }elseif ($action === 'update_reserva') {
        $id_reserva = $_POST['id_reserva'];
        $estado_reserva = $_POST['estado_reserva'];
    
        $query = "UPDATE Reservas SET estado_reserva = ? WHERE id_reserva = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $estado_reserva, $id_reserva);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Reserva actualizada exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar la reserva: ' . $stmt->error]);
        }
        $stmt->close();
    }
    elseif ($action === 'get_reservas') {
        $searchTerm = $_POST['searchTerm'] ?? '';
        $page = $_POST['page'] ?? 1;
        $limit = 5; // Número de items por página
        $offset = ($page - 1) * $limit;
    
        // Query para obtener los datos con paginación
        $query = "SELECT SQL_CALC_FOUND_ROWS Reservas.*, Usuarios.nombre AS nombre_cliente, Usuarios.apellido AS apellido_cliente, Habitaciones.numero AS numero_habitacion, Habitaciones.tipo_habitacion 
                  FROM Reservas
                  JOIN Usuarios ON Reservas.id_usuario = Usuarios.id_usuario
                  JOIN Habitaciones ON Reservas.id_habitacion = Habitaciones.id_habitacion
                  WHERE Usuarios.nombre LIKE CONCAT('%', ?, '%') OR Usuarios.apellido LIKE CONCAT('%', ?, '%')
                  LIMIT ?, ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssii", $searchTerm, $searchTerm, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $reservas = $result->fetch_all(MYSQLI_ASSOC);
    
        // Query para obtener el total de registros sin límite
        $resultTotal = $conn->query("SELECT FOUND_ROWS() as total");
        $total = $resultTotal->fetch_assoc()['total'];
    
        echo json_encode(['success' => true, 'data' => $reservas, 'total' => $total, 'page' => $page, 'total_pages' => ceil($total / $limit)]);
        $stmt->close();
    }
    elseif ($action === 'get_reserva_by_id') {
        $id_reserva = $_POST['id_reserva'];

        $query = "SELECT Reservas.*, Usuarios.nombre AS nombre_cliente, Usuarios.apellido AS apellido_cliente, Habitaciones.numero AS numero_habitacion, Habitaciones.tipo_habitacion 
                  FROM Reservas
                  JOIN Usuarios ON Reservas.id_usuario = Usuarios.id_usuario
                  JOIN Habitaciones ON Reservas.id_habitacion = Habitaciones.id_habitacion
                  WHERE Reservas.id_reserva = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_reserva);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $reserva = $result->fetch_assoc();
            echo json_encode(['success' => true, 'data' => $reserva]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Reserva no encontrada']);
        }
        $stmt->close();
    } elseif ($action === 'delete_reserva') {
        $id_reserva = $_POST['id_reserva'];

        $query = "DELETE FROM Reservas WHERE id_reserva = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_reserva);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Reserva eliminada exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar la reserva: ' . $stmt->error]);
        }
        $stmt->close();
    }

    $conn->close();
}

