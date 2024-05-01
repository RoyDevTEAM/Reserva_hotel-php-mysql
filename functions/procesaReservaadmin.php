<?php
include_once '../config/database.php';

class Reserva {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->connect();
        if ($this->conn->connect_error) {
            echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $this->conn->connect_error]);
            exit;
        }
    }

    public function handleRequest() {
        $action = $_POST['action'] ?? '';
        switch ($action) {
            case 'verificarDisponibilidad':
                $fecha_entrada = $_POST['fecha_entrada'];
                $fecha_salida = $_POST['fecha_salida'];
                echo $this->verificarDisponibilidad($fecha_entrada, $fecha_salida);
                break;
                case 'realizarReserva':
                    $id_usuario = $_POST['id_usuario'];
                    $id_habitacion = $_POST['id_habitacion'];
                    $fecha_entrada = $_POST['fecha_entrada'];
                    $fecha_salida = $_POST['fecha_salida'];
                    $costo_total = $_POST['costo_total'];
                    $servicios = $_POST['servicios'] ?? [];  // Asegúrate de pasar esto correctamente desde el frontend
                    $metodo_pago = $_POST['metodo_pago'];
                
                    $reservaResponse = $this->realizarReserva($id_usuario, $id_habitacion, $fecha_entrada, $fecha_salida, $costo_total);
                    $reservaData = json_decode($reservaResponse, true);
                    if ($reservaData['success']) {
                        $id_reserva = $reservaData['reserva_id'];
                        $this->agregarServiciosReserva($id_reserva, $servicios);
                        echo $this->realizarPago($id_reserva, $costo_total, $metodo_pago);
                    } else {
                        echo $reservaResponse;  // En caso de que la reserva falle, retorna el error.
                    }
                    break;
                
            case 'calcularCostoTotal':
                $id_habitacion = $_POST['id_habitacion'];
                $fecha_entrada = $_POST['fecha_entrada'];
                $fecha_salida = $_POST['fecha_salida'];
                echo $this->calcularCostoTotal($id_habitacion, $fecha_entrada, $fecha_salida);
                break;
            case 'buscarClientes':
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'] ?? '';
                echo $this->buscarClientes($nombre, $apellido);
                break;
            case 'traerServicios':
                echo $this->traerServicios();
                break;
            case 'traerTiposDePago':
                echo $this->traerTiposDePago();
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Acción no reconocida']);
                break;
        }
    }

    private function verificarDisponibilidad($fecha_entrada, $fecha_salida) {
        $sql = "SELECT * FROM Habitaciones WHERE estado = 'disponible' AND id_habitacion NOT IN (
                    SELECT id_habitacion FROM Reservas WHERE 
                    (fecha_entrada BETWEEN ? AND ?) OR
                    (fecha_salida BETWEEN ? AND ?) OR
                    (fecha_entrada <= ? AND fecha_salida >= ?)
                )";
        if ($stmt = $this->conn->prepare($sql)) {
            // Enlaza las variables de fecha con los parámetros de la consulta SQL
            $stmt->bind_param("ssssss", $fecha_entrada, $fecha_salida, $fecha_entrada, $fecha_salida, $fecha_entrada, $fecha_salida);
            $stmt->execute();
            $result = $stmt->get_result();
    
            $habitaciones = [];
            while ($row = $result->fetch_assoc()) {
                $habitaciones[] = $row;
            }
            return json_encode(['success' => true, 'habitaciones' => $habitaciones]);
        } else {
            return json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . $this->conn->error]);
        }
    }
    
    private function traerServicios() {
        $sql = "SELECT * FROM Servicios";
        if ($result = $this->conn->query($sql)) {
            $servicios = [];
            while ($row = $result->fetch_assoc()) {
                $servicios[] = $row;
            }
            return json_encode(['success' => true, 'servicios' => $servicios]);
        } else {
            return json_encode(['success' => false, 'message' => 'Error al recuperar los servicios: ' . $this->conn->error]);
        }
    }
    
  
    private function realizarReserva($id_usuario, $id_habitacion, $fecha_entrada, $fecha_salida, $costo_total) {
        $sql = "INSERT INTO Reservas (id_usuario, id_habitacion, fecha_entrada, fecha_salida, costo_total, estado_reserva) VALUES (?, ?, ?, ?, ?, 'pendiente')";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("iissd", $id_usuario, $id_habitacion, $fecha_entrada, $fecha_salida, $costo_total);
            if ($stmt->execute()) {
                $id_reserva = $this->conn->insert_id;
                return json_encode(['success' => true, 'message' => 'Reserva realizada con éxito.', 'reserva_id' => $id_reserva]);
            } else {
                return json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta de reserva: ' . $stmt->error]);
            }
        } else {
            return json_encode(['success' => false, 'message' => 'Error al preparar la consulta de reserva: ' . $this->conn->error]);
        }
    }
    
    private function traerTiposDePago() {
        $sql = "SHOW COLUMNS FROM Pagos LIKE 'metodo_pago'";
        if ($result = $this->conn->query($sql)) {
            if ($row = $result->fetch_assoc()) {
                $type = $row["Type"];
                preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
                $enum = explode("','", trim($matches[1], "'"));
                return json_encode(['success' => true, 'metodos_pago' => $enum]);
            } else {
                return json_encode(['success' => false, 'message' => 'No se encontraron métodos de pago.']);
            }
        } else {
            return json_encode(['success' => false, 'message' => 'Error al recuperar tipos de pago: ' . $this->conn->error]);
        }
    }
    
    private function calcularCostoTotal($id_habitacion, $fecha_entrada, $fecha_salida) {
        $sql = "SELECT precio_noche FROM Habitaciones WHERE id_habitacion = ?";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("i", $id_habitacion);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $precio_noche = $row['precio_noche'];
                $dias = (strtotime($fecha_salida) - strtotime($fecha_entrada)) / (60 * 60 * 24);
                return json_encode(['success' => true, 'costo_total' => $dias * $precio_noche]);
            } else {
                return json_encode(['success' => false, 'message' => 'No se encontró la información de la habitación.']);
            }
        } else {
            return json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . $this->conn->error]);
        }
    }
    
    private function buscarClientes($nombre, $apellido) {
        $sql = "SELECT * FROM Usuarios WHERE nombre LIKE ? AND apellido LIKE ? AND tipo_usuario = 'cliente'";
        if ($stmt = $this->conn->prepare($sql)) {
            $nombre = "%$nombre%";
            $apellido = "%$apellido%";
            $stmt->bind_param("ss", $nombre, $apellido);
            $stmt->execute();
            $result = $stmt->get_result();
            $clientes = [];
            while ($row = $result->fetch_assoc()) {
                $clientes[] = $row;
            }
            return json_encode(['success' => true, 'clientes' => $clientes]);
        } else {
            return json_encode(['success' => false, 'message' => 'Error al preparar la consulta de clientes: ' . $this->conn->error]);
        }
    }
    private function agregarServiciosReserva($id_reserva, $servicios) {
        foreach ($servicios as $id_servicio) {
            $sql = "INSERT INTO Reserva_Servicios (id_reserva, id_servicio) VALUES (?, ?)";
            if ($stmt = $this->conn->prepare($sql)) {
                $stmt->bind_param("ii", $id_reserva, $id_servicio);
                if (!$stmt->execute()) {
                    return json_encode(['success' => false, 'message' => 'Error al insertar servicio en la reserva: ' . $stmt->error]);
                }
            } else {
                return json_encode(['success' => false, 'message' => 'Error al preparar la consulta de inserción de servicio: ' . $this->conn->error]);
            }
        }
        return json_encode(['success' => true, 'message' => 'Servicios añadidos a la reserva correctamente.']);
    }
    private function realizarPago($id_reserva, $monto, $metodo_pago) {
        $sql = "INSERT INTO Pagos (id_reserva, fecha_pago, monto, metodo_pago, estado_pago) VALUES (?, CURDATE(), ?, ?, 'pendiente')";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("ids", $id_reserva, $monto, $metodo_pago);
            if ($stmt->execute()) {
                return json_encode(['success' => true, 'message' => 'Pago registrado con éxito.']);
            } else {
                return json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta de pago: ' . $stmt->error]);
            }
        } else {
            return json_encode(['success' => false, 'message' => 'Error al preparar la consulta de pago: ' . $this->conn->error]);
        }
    }
        

}

$reserva = new Reserva();
$reserva->handleRequest();
?>
