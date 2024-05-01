<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
</head>
<body>
<?php include_once '../../template/header.php'; ?>

<div class="container mx-auto px-4 py-4">
    <h1 class="text-xl font-bold text-center mb-6">Reporte de Clientes</h1>
    <table id="clientesTable" class="display compact cell-border stripe" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#clientesTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "../../functions/reporte.php",
            dataSrc: 'data'
        },
        columns: [
            { data: "id_usuario" },
            { data: "nombre" },
            { data: "apellido" },
            { data: "email" },
            { data: "telefono" },
            { data: "direccion" }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
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
