<?php
include_once '../config/database.php';

$database = new Database();
$conn = $database->connect();

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $type = $_GET['type'] ?? '';

    switch ($type) {
        case 'servicios':
            $query = "SELECT id_servicio, nombre, precio FROM Servicios ORDER BY nombre";
            $result = $conn->query($query);
            if ($result) {
                $servicios = $result->fetch_all(MYSQLI_ASSOC);
                $response = ['success' => true, 'servicios' => $servicios];
            } else {
                $response['message'] = 'Error al obtener servicios: ' . $conn->error;
            }
            break;
        case 'metodos_pago':
            $metodosPago = [
                ['id' => 'efectivo', 'nombre' => 'Efectivo'],
                ['id' => 'qr', 'nombre' => 'Pago por QR'],
                ['id' => 'transferencia', 'nombre' => 'Transferencia Bancaria']
            ];
            $response = ['success' => true, 'metodos_pago' => $metodosPago];
            break;
        default:
            $response['message'] = 'Tipo de consulta no válido';
            break;
    }
    echo json_encode($response);
    $conn->close();
}
?>
