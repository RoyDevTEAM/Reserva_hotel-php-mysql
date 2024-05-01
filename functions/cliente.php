<?php
include_once '../config/database.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action === 'get_clientes') {
        // Recoger el término de búsqueda si existe, si no, se busca con un string vacío que no filtra nada
        $searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : '';
    
        // Preparar la consulta SQL con filtros para nombre y apellido
        $query = "SELECT * FROM Usuarios WHERE tipo_usuario = 'cliente' AND (nombre LIKE CONCAT('%', ?, '%') OR apellido LIKE CONCAT('%', ?, '%'))";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . $conn->error]);
            exit;
        }
    
        // Bind parameters
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
    
        // Ejecutar la consulta
        $stmt->execute();
        $result = $stmt->get_result();
        $clientes = $result->fetch_all(MYSQLI_ASSOC);
    
        // Cerrar el statement
        $stmt->close();
    
        // Devolver los resultados
        echo json_encode($clientes);
    }
    elseif ($action === 'create_cliente') {
        // Crear un nuevo cliente
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT); // Hash de contraseña para seguridad
    
        // Preparar la consulta SQL
        $query = "INSERT INTO Usuarios (nombre, apellido, email, telefono, direccion, tipo_usuario, contraseña) VALUES (?, ?, ?, ?, ?, 'cliente', ?)";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . $conn->error]);
            return;
        }
    
        // Vincular parámetros y ejecutar consulta
        $stmt->bind_param("ssssss", $nombre, $apellido, $email, $telefono, $direccion, $contraseña);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Cliente creado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear cliente: ' . $stmt->error]);
        }
        $stmt->close();
    }
    elseif ($action === 'update_cliente') {
        // Actualizar un cliente existente
        $id_usuario = $_POST['id_usuario'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $contraseña = $_POST['contraseña'];
    
        // Preparar la consulta base sin incluir la contraseña
        $query = "UPDATE Usuarios SET nombre = ?, apellido = ?, email = ?, telefono = ?, direccion = ? WHERE id_usuario = ? AND tipo_usuario = 'cliente'";
        $types = "sssssi"; // Tipos para bind_param
        $params = array(&$nombre, &$apellido, &$email, &$telefono, &$direccion, &$id_usuario);
    
        // Incluir la contraseña solo si se ha proporcionado una nueva
        if (!empty($contraseña)) {
            $contraseñaHash = password_hash($contraseña, PASSWORD_DEFAULT); // Hash de la contraseña
            $query = "UPDATE Usuarios SET nombre = ?, apellido = ?, email = ?, telefono = ?, direccion = ?, contraseña = ? WHERE id_usuario = ? AND tipo_usuario = 'cliente'";
            $types .= "s"; // Agregar el tipo de parámetro para la contraseña
            $params[] = &$contraseñaHash;
        }
    
        $stmt = $conn->prepare($query);
        if (false === $stmt) {
            echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . $conn->error]);
            exit;
        }
    
        $stmt->bind_param($types, ...$params);
    
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Cliente actualizado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar cliente: ' . $stmt->error]);
        }
    
        $stmt->close();
    }
    elseif ($action === 'get_cliente_by_id') {
        // Obtener un cliente específico por ID
        $id_usuario = $_POST['id_usuario'];
        $query = "SELECT * FROM Usuarios WHERE id_usuario = ? AND tipo_usuario = 'cliente'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $cliente = $result->fetch_assoc();
        if ($cliente) {
            echo json_encode($cliente);
        } else {
            echo json_encode(['success' => false, 'message' => 'Cliente no encontrado']);
        }
        $stmt->close();
    } elseif ($action === 'delete_cliente') {
        // Eliminar un cliente
        $id_usuario = $_POST['id_usuario'];

        $query = "DELETE FROM Usuarios WHERE id_usuario = ? AND tipo_usuario = 'cliente'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Cliente eliminado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar cliente: ' . $stmt->error]);
        }
        $stmt->close();
    }

    $conn->close();
}
?>
