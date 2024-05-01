<?php
include_once '../config/database.php';

$database = new Database();
$conn = $database->connect();

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'get_habitaciones':
            $query = "SELECT *, CONCAT('/hotel_ajax/img/habitacion', id_habitacion, '.jpg') AS imagen FROM Habitaciones";
            $result = $conn->query($query);
            if ($result) {
                $habitaciones = $result->fetch_all(MYSQLI_ASSOC);
                $response = ['success' => true, 'data' => $habitaciones];
            } else {
                $response['message'] = 'Error al obtener las habitaciones: ' . $conn->error;
            }
            break;

        default:
            $response['message'] = 'Acción no válida.';
            break;
    }

    echo json_encode($response);
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método HTTP no soportado.']);
}
?>
