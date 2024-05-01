<?php
include_once '../config/database.php';

$database = new Database();
$conn = $database->connect();

// Parámetros de DataTables
$params = $_REQUEST;
$draw = intval($params['draw']);
$start = intval($params['start']);
$length = intval($params['length']);
$estado = $params['estado'];
$nombreCliente = $params['nombreCliente'];

// Construir la consulta SQL base
$sql = "SELECT Reservas.id_reserva, Reservas.fecha_entrada, Reservas.fecha_salida, Reservas.estado_reserva, Usuarios.nombre, Usuarios.apellido 
        FROM Reservas
        JOIN Usuarios ON Reservas.id_usuario = Usuarios.id_usuario";

// Contar el total de registros sin filtro
$sqlCount = "SELECT COUNT(*) as cnt FROM Reservas JOIN Usuarios ON Reservas.id_usuario = Usuarios.id_usuario";
$countResult = mysqli_query($conn, $sqlCount);
$rowCount = mysqli_fetch_assoc($countResult);
$totalRecords = $rowCount['cnt'];

// Aplicar filtros
$whereConditions = [];
if (!empty($estado) && $estado !== 'todos') {
    $whereConditions[] = "Reservas.estado_reserva = '" . mysqli_real_escape_string($conn, $estado) . "'";
}
if (!empty($nombreCliente)) {
    $nombreCliente = mysqli_real_escape_string($conn, $nombreCliente);
    $whereConditions[] = "(Usuarios.nombre LIKE '%" . $nombreCliente . "%' OR Usuarios.apellido LIKE '%" . $nombreCliente . "%')";
}
if (!empty($whereConditions)) {
    $sql .= " WHERE " . implode(" AND ", $whereConditions);
}

// Contar el total de registros filtrados
$totalFiltered = $totalRecords;
if (!empty($whereConditions)) {
    $sqlFiltered = "SELECT COUNT(*) as cnt FROM ($sql) as sub";
    $filteredResult = mysqli_query($conn, $sqlFiltered);
    $rowFiltered = mysqli_fetch_assoc($filteredResult);
    $totalFiltered = $rowFiltered['cnt'];
}

// Añadir orden y paginación
$orderColumn = array(0 => 'id_reserva', 1 => 'nombre', 2 => 'fecha_entrada', 3 => 'fecha_salida', 4 => 'estado_reserva');
$sql .= " ORDER BY " . $orderColumn[$params['order'][0]['column']] . " " . $params['order'][0]['dir'] .
        " LIMIT " . $start . ", " . $length;

// Obtener los datos de la base de datos
$result = mysqli_query($conn, $sql);
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        "id_reserva" => $row["id_reserva"],
        "nombre" => $row["nombre"] . ' ' . $row["apellido"],
        "fecha_entrada" => $row["fecha_entrada"],
        "fecha_salida" => $row["fecha_salida"],
        "estado" => $row["estado_reserva"]
    ];
}

// Devolver los datos en formato JSON
$json_data = array(
    "draw" => intval($draw),
    "recordsTotal" => intval($totalRecords),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
);
echo json_encode($json_data);
?>
