<?php
include_once '../config/database.php';

$database = new Database();
$conn = $database->connect();

// Query to fetch all clients
$query = "SELECT id_usuario, nombre, apellido, email, telefono, direccion FROM Usuarios WHERE tipo_usuario = 'cliente'";
$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode(['data' => $data]);
?>
