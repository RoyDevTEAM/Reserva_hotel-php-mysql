<?php
include_once '../config/database.php';

// Crear instancia de la base de datos
$database = new Database();
$conn = $database->connect();

// Verificar que el método es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Preparar la consulta SQL
        $stmt = $conn->prepare("SELECT id_usuario, nombre, apellido, tipo_usuario, contraseña FROM Usuarios WHERE nombre = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            // Verificar la contraseña
            if (password_verify($password, $user['contraseña'])) {
                echo json_encode([
                    'success' => true,
                    'id_usuario' => $user['id_usuario'],
                    'nombre' => $user['nombre'],
                    'apellido' => $user['apellido'],
                    'tipo_usuario' => $user['tipo_usuario']
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        }

        $stmt->close();
    } elseif ($_POST['action'] == 'logout') {
        // simplemente puedes devolver una confirmación de que la sesión se puede "cerrar" desde el lado del cliente
        echo json_encode(['success' => true, 'message' => 'Sesión cerrada correctamente']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Acción no válida o datos no proporcionados']);
}

$conn->close();
?>
