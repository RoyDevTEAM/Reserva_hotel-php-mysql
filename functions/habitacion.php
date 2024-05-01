<?php
include_once '../config/database.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action === 'get_habitaciones') {
        $searchTerm = isset($_POST['searchTerm']) ? "%{$_POST['searchTerm']}%" : '%';

        // Filtrar por número o tipo de habitación
        $query = "SELECT * FROM Habitaciones WHERE numero LIKE ? OR tipo_habitacion LIKE ? ORDER BY numero";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        $habitaciones = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($habitaciones);
    } 
    elseif ($action === 'create_habitacion') {
        // Suponiendo que se envían todos los datos necesarios para crear una habitación
        $numero = $_POST['numero'];
        $tipo_habitacion = $_POST['tipo_habitacion'];
        $descripcion = $_POST['descripcion'];
        $capacidad = $_POST['capacidad'];
        $precio_noche = $_POST['precio_noche'];
        $estado = $_POST['estado'];

        $query = "INSERT INTO Habitaciones (numero, tipo_habitacion, descripcion, capacidad, precio_noche, estado) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssiis", $numero, $tipo_habitacion, $descripcion, $capacidad, $precio_noche, $estado);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Habitación creada exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear habitación: ' . $stmt->error]);
        }
    }
    
    elseif ($action === 'update_habitacion') {
        // Verificar que todos los datos necesarios están presentes
        if (isset($_POST['id_habitacion'], $_POST['numero'], $_POST['tipo_habitacion'], $_POST['descripcion'], $_POST['capacidad'], $_POST['precio_noche'], $_POST['estado'])) {
            $id_habitacion = $_POST['id_habitacion'];
            $numero = $_POST['numero'];
            $tipo_habitacion = $_POST['tipo_habitacion'];
            $descripcion = $_POST['descripcion'];
            $capacidad = $_POST['capacidad'];
            $precio_noche = $_POST['precio_noche'];
            $estado = $_POST['estado'];
    
            // Preparar y ejecutar la consulta de actualización
            $query = "UPDATE Habitaciones SET numero = ?, tipo_habitacion = ?, descripcion = ?, capacidad = ?, precio_noche = ?, estado = ? WHERE id_habitacion = ?";
            $stmt = $conn->prepare($query);
            if ($stmt === false) {
                echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . $conn->error]);
            } else {
                $stmt->bind_param("sssiisi", $numero, $tipo_habitacion, $descripcion, $capacidad, $precio_noche, $estado, $id_habitacion);
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Habitación actualizada exitosamente']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar habitación: ' . $stmt->error]);
                }
                $stmt->close();
            }
        } else {
            // Algunos datos requeridos faltan
            echo json_encode(['success' => false, 'message' => 'Datos incompletos para actualizar la habitación']);
        }
    }
    
    
    elseif ($action === 'get_habitacion_by_id') {
        // Obtener una habitación por su ID
        $id_habitacion = $_POST['id_habitacion'];

        $query = "SELECT * FROM Habitaciones WHERE id_habitacion = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_habitacion);
        $stmt->execute();
        $result = $stmt->get_result();
        $habitacion = $result->fetch_assoc();
        echo json_encode($habitacion);
    }
    elseif ($action === 'delete_habitacion') {
        $id_habitacion = $_POST['id_habitacion'];
    
        // Verificar si la habitación está vinculada a alguna reserva activa
        $consultaReservas = "SELECT COUNT(*) as count FROM Reservas WHERE id_habitacion = ? AND estado_reserva != 'completada'";
        $stmtReservas = $conn->prepare($consultaReservas);
        $stmtReservas->bind_param("i", $id_habitacion);
        $stmtReservas->execute();
        $resultadoReservas = $stmtReservas->get_result()->fetch_assoc();
        $stmtReservas->close();
    
        // Si hay reservas activas, no se puede eliminar la habitación
        if($resultadoReservas['count'] > 0) {
            echo json_encode(['success' => false, 'message' => 'La habitación está vinculada a reservas activas y no puede ser eliminada.']);
        } else {
            // Si no hay reservas activas, procedemos a eliminar la habitación
            $query = "DELETE FROM Habitaciones WHERE id_habitacion = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id_habitacion);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Habitación eliminada exitosamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al eliminar habitación: ' . $stmt->error]);
            }
            $stmt->close();
        }
    }
    

    $conn->close();
}
?>
