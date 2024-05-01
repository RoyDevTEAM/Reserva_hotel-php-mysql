<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
</head>
<body>
<?php include_once '../../template/header.php'; ?>

<div class="container mx-auto px-4 py-4">
    <h1 class="text-xl font-bold text-center mb-6">Reporte de Reservas</h1>
    <div>
        <label for="estado">Estado de la reserva:</label>
        <select id="estado">
            <option value="todos">Todos</option>
            <option value="pendiente">Pendiente</option>
            <option value="confirmada">Confirmada</option>
            <option value="cancelada">Cancelada</option>
            <option value="completada">Completada</option>
        </select>
        <label for="nombreCliente">Buscar por cliente:</label>
        <input type="text" id="nombreCliente">
    </div>
    <table id="reservasTable" class="display compact cell-border stripe" style="width:100%">
        <thead>
            <tr>
                <th>ID Reserva</th>
                <th>Cliente</th>
                <th>Fecha Entrada</th>
                <th>Fecha Salida</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    var table = $('#reservasTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "../../functions/reservaReporte.php",
            data: function(d) {
                d.estado = $('#estado').val();
                d.nombreCliente = $('#nombreCliente').val();
            }
        },
        columns: [
            { data: "id_reserva" },
            { data: "nombre" },
            { data: "fecha_entrada" },
            { data: "fecha_salida" },
            { data: "estado" }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    // Evento de cambio para actualizar la tabla automáticamente
    $('#estado, #nombreCliente').on('change keyup', function() {
        table.ajax.reload();
    });
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
</body>
</html>
