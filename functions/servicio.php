<?php
include_once '../config/database.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? 'none'; // Asegurarse de que hay una acción definida

    switch ($action) {
        case 'get_servicios':
            $query = "SELECT *, CONCAT('/hotel_ajax/img/servicio', id_servicio, '.jpg') AS imagen FROM Servicios";
            $result = $conn->query($query); // Ejecuta la consulta
            if ($result && $result->num_rows > 0) {
                $servicios = $result->fetch_all(MYSQLI_ASSOC);
                echo json_encode(['success' => true, 'data' => $servicios]); // Envía la respuesta aquí
            } else {
                echo json_encode(['success' => false, 'message' => "Error en la consulta: " . $conn->error]); // Envía error específico de la consulta
            }
            break;

        default:
            echo json_encode(['success' => false, 'message' => "Acción no reconocida"]); // Maneja el caso de acción no reconocida
            break;
    }
} else {
    echo json_encode(['success' => false, 'message' => "Método no soportado"]); // Respuesta para métodos no POST
}

$conn->close(); // Cierra la conexión a la base de datos
?>
