<?php
require_once '../config/database.php'; // Incluir el archivo de conexión a la base de datos

$database = new Database();
$conn = $database->connect();

$idReserva = $_GET['id_reserva'] ?? 'Desconocido';
$metodoPago = $_GET['metodo_pago'] ?? 'Desconocido';
$monto = $_GET['monto'] ?? '0';

$query = "SELECT u.nombre FROM Reservas r JOIN Usuarios u ON r.id_usuario = u.id_usuario WHERE r.id_reserva = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idReserva);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc()['nombre'] ?? 'Cliente Desconocido';

// Convertir la imagen a Base64
$logoPath = 'https://i.pinimg.com/736x/10/ff/aa/10ffaadab6bc3c4c1dd4a3e44bf6d5ad.jpg'; // Asegúrate de tener la ruta correcta y permisos
$logoData = file_get_contents($logoPath);
$logoBase64 = 'data:image/jpg;base64,' . base64_encode($logoData);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura de Reserva</title>
    <!-- PDFMake -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
</head>
<body onload="generatePDF()">
    <script>
        function generatePDF() {
            var docDefinition = {
                content: [
                    {
                        columns: [
                            {
                                image: "<?php echo $logoBase64; ?>",
                                width: 100
                            },
                            {
                                text: 'Hotel Service',
                                style: 'header',
                                alignment: 'right'
                            }
                        ],
                        columnGap: 10
                    },
                    {
                        style: 'tableExample',
                        table: {
                            widths: ['*', '*', '*', '*'],
                            body: [
                                ['Reserva N°', '<?php echo $idReserva; ?>', 'Cliente', '<?php echo $cliente; ?>'],
                                ['Método de Pago', '<?php echo $metodoPago; ?>', 'Monto Pagado', '$<?php echo $monto; ?>']
                            ]
                        },
                        layout: {
                            fillColor: function (rowIndex, node, columnIndex) {
                                return (rowIndex % 2 === 0) ? '#f2f2f2' : null;
                            }
                        },
                        margin: [0, 20, 0, 0]
                    },
                    {
                        text: 'Gracias por elegir nuestro hotel. ¡Esperamos verte pronto!',
                        style: 'footer'
                    }
                ],
                styles: {
                    header: {
                        fontSize: 22,
                        bold: true,
                        margin: [0, 20, 0, 10]
                    },
                    tableExample: {
                        margin: [0, 5, 0, 15]
                    },
                    footer: {
                        bold: true,
                        fontSize: 12,
                        color: '#006621',
                        margin: [0, 10, 0, 0],
                        alignment: 'center'
                    }
                },
                defaultStyle: {
                    columnGap: 20,
                }
            };
            pdfMake.createPdf(docDefinition).download('factura-reserva-<?php echo $idReserva; ?>.pdf');
        }
    </script>
</body>
</html>
