<?php
include_once '../config/database.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action === 'create_pago') {
        $id_reserva = $_POST['id_reserva'];
        $fecha_pago = $_POST['fecha_pago'];
        $monto = $_POST['monto'];
        $metodo_pago = $_POST['metodo_pago'];
        $estado_pago = $_POST['estado_pago'];

        $query = "INSERT INTO Pagos (id_reserva, fecha_pago, monto, metodo_pago, estado_pago) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isdss", $id_reserva, $fecha_pago, $monto, $metodo_pago, $estado_pago);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Pago registrado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar el pago: ' . $stmt->error]);
        }
        $stmt->close();
    } elseif ($action === 'update_pago') {
        $id_pago = $_POST['id_pago'];
        $estado_pago = $_POST['estado_pago'];

        $query = "UPDATE Pagos SET estado_pago = ? WHERE id_pago = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $estado_pago, $id_pago);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Pago actualizado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el pago: ' . $stmt->error]);
        }
        $stmt->close();
    } elseif ($action === 'get_pago_by_id') {
        $id_pago = $_POST['id_pago'];

        $query = "SELECT * FROM Pagos WHERE id_pago = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_pago);
        $stmt->execute();
        $result = $stmt->get_result();
        $pago = $result->fetch_assoc();
        echo json_encode($pago);
        $stmt->close();
    } elseif ($action === 'get_pagos_by_metodo') {
        $metodo_pago = $_POST['metodo_pago'];

        $query = "SELECT * FROM Pagos WHERE metodo_pago = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $metodo_pago);
        $stmt->execute();
        $result = $stmt->get_result();
        $pagos = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success' => true, 'data' => $pagos]);
        $stmt->close();
    } elseif ($action === 'delete_pago') {
        $id_pago = $_POST['id_pago'];

        $query = "DELETE FROM Pagos WHERE id_pago = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_pago);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Pago eliminado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el pago: ' . $stmt->error]);
        }
        $stmt->close();
    }

    $conn->close();
}
?>
