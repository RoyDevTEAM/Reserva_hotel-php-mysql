<?php
include_once '../config/database.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action === 'get_usuarios') {
        $searchTerm = isset($_POST['searchTerm']) ? "%{$_POST['searchTerm']}%" : '%';
        $query = "SELECT * FROM Usuarios WHERE (tipo_usuario = 'empleado' OR tipo_usuario = 'admin') AND (nombre LIKE ? OR apellido LIKE ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuarios = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($usuarios);
        $stmt->close();

    }
    
    elseif ($action === 'create_usuario') {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $tipo_usuario = $_POST['tipo_usuario']; // Debe ser 'empleado' o 'admin'
        $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

        $query = "INSERT INTO Usuarios (nombre, apellido, email, telefono, direccion, tipo_usuario, contraseña) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssss", $nombre, $apellido, $email, $telefono, $direccion, $tipo_usuario, $contraseña);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Usuario creado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear usuario: ' . $stmt->error]);
        }
        $stmt->close();
    } 
    elseif ($action === 'update_usuario') {
        $id_usuario = $_POST['id_usuario'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $tipo_usuario = $_POST['tipo_usuario'];
        $contraseña = !empty($_POST['contraseña']) ? password_hash($_POST['contraseña'], PASSWORD_DEFAULT) : null;
    
        // Construir la consulta base
        $query = "UPDATE Usuarios SET nombre = ?, apellido = ?, email = ?, telefono = ?, direccion = ?, tipo_usuario = ?";
        $params = [$nombre, $apellido, $email, $telefono, $direccion, $tipo_usuario];
        $types = "ssssss"; // Tipos de parámetros para bind_param
    
        // Agregar la contraseña al query si es proporcionada
        if ($contraseña) {
            $query .= ", contraseña = ?";
            $params[] = $contraseña;
            $types .= "s"; // Agregar tipo de parámetro para la contraseña
        }
    
        // Agregar condiciones para ejecutar la actualización
        $query .= " WHERE id_usuario = ?";
        $params[] = $id_usuario;
        $types .= "i"; // Agregar tipo de parámetro para el ID de usuario
    
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . $conn->error]);
            exit;
        }
    
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Usuario actualizado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar usuario: ' . $stmt->error]);
        }
        $stmt->close();
    }
    
    elseif ($action === 'get_usuario_by_id') {
        $id_usuario = $_POST['id_usuario'];
        $query = "SELECT * FROM Usuarios WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        echo json_encode($usuario);
        $stmt->close();
    } 
    elseif ($action === 'delete_usuario') {
        $id_usuario = $_POST['id_usuario'];
        $query = "DELETE FROM Usuarios WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Usuario eliminado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar usuario: ' . $stmt->error]);
        }
        $stmt->close();
    }

    $conn->close();
}
?>
