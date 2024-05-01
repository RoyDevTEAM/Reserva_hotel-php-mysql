<?php
include_once '../config/database.php';

function getMonthlyReservationCount() {
    $database = new Database();
    $conn = $database->connect();

    $query = "SELECT COUNT(*) AS count FROM Reservas WHERE MONTH(fecha_entrada) = MONTH(CURRENT_DATE()) AND YEAR(fecha_entrada) = YEAR(CURRENT_DATE())";
    $result = $conn->query($query);
    $data = $result->fetch_assoc();
    return $data['count'];
}

function getTotalRevenueThisMonth() {
    $database = new Database();
    $conn = $database->connect();

    $query = "SELECT SUM(costo_total) AS total FROM Reservas WHERE MONTH(fecha_entrada) = MONTH(CURRENT_DATE()) AND YEAR(fecha_entrada) = YEAR(CURRENT_DATE())";
    $result = $conn->query($query);
    $data = $result->fetch_assoc();
    return $data['total'];
}

function getMostFrequentClient() {
    $database = new Database();
    $conn = $database->connect();

    $query = "SELECT u.nombre, COUNT(*) AS count FROM Reservas r JOIN Usuarios u ON r.id_usuario = u.id_usuario GROUP BY r.id_usuario ORDER BY count DESC LIMIT 1";
    $result = $conn->query($query);
    $data = $result->fetch_assoc();
    return $data ? $data['nombre'] : 'No data';
}

function getTotalRevenueOverall() {
    $database = new Database();
    $conn = $database->connect();

    $query = "SELECT SUM(costo_total) AS total FROM Reservas";
    $result = $conn->query($query);
    $data = $result->fetch_assoc();
    return $data['total'];
}

function getPendingReservations() {
    $database = new Database();
    $conn = $database->connect();

    $query = "SELECT * FROM Reservas WHERE estado_reserva = 'pendiente'";
    $result = $conn->query($query);
    $reservations = [];
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
    return $reservations;
}

// Función para obtener el número de reservas de los últimos 5 meses
function getReservationsLastFiveMonths() {
    $database = new Database();
    $conn = $database->connect();

    $query = "SELECT DATE_FORMAT(fecha_entrada, '%Y-%m') AS month, COUNT(*) AS count 
              FROM Reservas 
              WHERE fecha_entrada BETWEEN DATE_SUB(CURRENT_DATE(), INTERVAL 5 MONTH) AND CURRENT_DATE() 
              GROUP BY month 
              ORDER BY month DESC";
    $result = $conn->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

// Función para obtener las habitaciones más reservadas
function getMostBookedRooms() {
    $database = new Database();
    $conn = $database->connect();

    $query = "SELECT tipo_habitacion, COUNT(*) AS count 
              FROM Reservas JOIN Habitaciones ON Reservas.id_habitacion = Habitaciones.id_habitacion 
              GROUP BY tipo_habitacion 
              ORDER BY count DESC 
              LIMIT 5";
    $result = $conn->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

// Función para obtener los tipos de pago más utilizados
function getMostUsedPaymentMethods() {
    $database = new Database();
    $conn = $database->connect();

    $query = "SELECT metodo_pago, COUNT(*) AS count 
              FROM Pagos 
              GROUP BY metodo_pago 
              ORDER BY count DESC";
    $result = $conn->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

header('Content-Type: application/json');
$response = [
    'monthlyReservations' => getMonthlyReservationCount(),
    'totalRevenueThisMonth' => getTotalRevenueThisMonth(),
    'mostFrequentClient' => getMostFrequentClient(),
    'totalRevenueOverall' => getTotalRevenueOverall(),
    'pendingReservations' => getPendingReservations(),
    'reservationsLastFiveMonths' => getReservationsLastFiveMonths(),
    'mostBookedRooms' => getMostBookedRooms(),
    'mostUsedPaymentMethods' => getMostUsedPaymentMethods()
];


echo json_encode($response);
?>
