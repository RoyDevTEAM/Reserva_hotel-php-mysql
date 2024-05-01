<?php
include_once '../config/database.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    // Crear una contraseña hash
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta para insertar el nuevo usuario de tipo 'cliente'
    $tipo_usuario = 'cliente';  // Aseguramos que el tipo es 'cliente'
    $query = "INSERT INTO Usuarios (nombre, apellido, email, contraseña, telefono, direccion, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta']);
        exit;
    }

    $stmt->bind_param("sssssss", $nombre, $apellido, $email, $passwordHash, $telefono, $direccion, $tipo_usuario);
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Registro exitoso',
            'tipo_usuario' => $tipo_usuario  // Enviamos el tipo de usuario en la respuesta
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario']);
    }

    $stmt->close();
    $conn->close();
}
?>
