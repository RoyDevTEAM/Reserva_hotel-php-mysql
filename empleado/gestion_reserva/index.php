<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reservas</title>
    <!-- Incluir Tailwind CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Incluir Tailwind CSS -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Incluir Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body class="bg-gray-100">
<?php include_once '../../template/header.php'; ?>
 <div class="container mx-auto p-4">
        <!-- Botón para agregar reserva -->
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4" onclick="location.href='crear.php'">
            <i class="fas fa-plus mr-2"></i>Añadir Reserva
        </button>

        <!-- Búsqueda -->
        <div class="mb-4">
            <input type="text" id="searchBox" class="form-input mt-1 block w-full p-2 border border-gray-300 rounded" placeholder="Buscar por cliente o habitación...">
        </div>

        <!-- Tabla para mostrar reservas -->
        <div id="reservasContainer" class="bg-white shadow-md rounded my-6">
            <!-- Las reservas se cargarán aquí mediante AJAX -->
        </div>

        <!-- Paginación -->
        <div id="pagination" class="mt-5">
            <!-- Los botones de paginación se cargarán aquí mediante AJAX -->
        </div>
    </div>
    <script >function cargarReservas(searchTerm = '', page = 1) {
    $.ajax({
        url: '../../functions/reserva.php',
        type: 'POST',
        data: {
            action: 'get_reservas',
            searchTerm: searchTerm,
            page: page // Parámetro de página actual
        },
        dataType: 'json',
        success: function(response) {
            let html = '<table class="min-w-full divide-y divide-gray-200 shadow-lg rounded-lg overflow-hidden">';
            html += '<thead class="bg-gray-800 text-white">';
            html += '<tr>';
            html += '<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Cliente</th>';
            html += '<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Habitación</th>';
            html += '<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Fecha Entrada</th>';
            html += '<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Fecha Salida</th>';
            html += '<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Costo Total</th>';
            html += '<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Estado</th>';
            html += '<th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Acciones</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody class="bg-white divide-y divide-gray-200">';

            response.data.forEach(function(reserva) {
                html += '<tr class="hover:bg-gray-50">';
                html += `<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${reserva.nombre_cliente} ${reserva.apellido_cliente}</td>`;
                html += `<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${reserva.numero_habitacion} (${reserva.tipo_habitacion})</td>`;
                html += `<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${reserva.fecha_entrada}</td>`;
                html += `<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${reserva.fecha_salida}</td>`;
                html += `<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$${reserva.costo_total}</td>`;
                html += `<td class="px-6 py-4 whitespace-nowrap text-sm font-semibold" style="color: ${reserva.estado_reserva === 'pendiente' ? '#dc2626' : '#16a34a'};">${reserva.estado_reserva}</td>`;
                html += '<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">';
                if (reserva.estado_reserva === 'pendiente') {
                    html += `<button onclick="confirmarReserva(${reserva.id_reserva})" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded inline-flex items-center"><i class="fas fa-check-circle"></i></button>`;
                }
                html += `<button onclick="imprimirFactura(${reserva.id_reserva})" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded inline-flex items-center ml-2"><i class="fas fa-print"></i></button>`;
                html += `<button onclick="editarReserva(${reserva.id_reserva})" class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded inline-flex items-center ml-2"><i class="fas fa-edit"></i></button>`;
                html += `<button onclick="eliminarReserva(${reserva.id_reserva})" class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded inline-flex items-center ml-2"><i class="fas fa-trash"></i></button>`;
                html += '</td>';
                html += '</tr>';
            });

            html += '</tbody>';
            html += '</table>';

            // Actualizar el contenedor de la tabla
            $('#reservasContainer').html(html);

            // Paginación
            updatePagination(response.total_pages, page);
        },
        error: function() {
            Swal.fire('Error', 'No se pudo cargar las reservas.', 'error');
        }
    });
}
window.imprimirFactura = function(id_reserva) {
        // Esto podría redirigir a una página de generación de factura o manejarlo de otra forma
        window.open(`/hotel_ajax/empleado/factura/factura.php?id_reserva=${id_reserva}`, '_blank');
    };
    window.confirmarReserva = function(id_reserva) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Estás por confirmar la reserva.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, confirmar!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../../functions/reserva.php',
                    type: 'POST',
                    data: {
                        action: 'update_reserva',
                        id_reserva: id_reserva,
                        estado_reserva: 'completada'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Confirmada!', 'La reserva ha sido confirmada.', 'success');
                            cargarReservas();
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'La solicitud no pudo completarse.', 'error');
                    }
                });
            }
        });
    };

    window.eliminarReserva = function(id_reserva) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'No podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, borrarlo!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../../functions/reserva.php',
                    type: 'POST',
                    data: {
                        action: 'delete_reserva',
                        id_reserva: id_reserva
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Eliminado!', 'La reserva ha sido eliminada.', 'success');
                            cargarReservas();
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'La solicitud no pudo completarse.', 'error');
                    }
                });
            }
        });
    };

function updatePagination(totalPages, currentPage) {
    let paginationHtml = '<div class="flex justify-center space-x-2">';
    for (let i = 1; i <= totalPages; i++) {
        paginationHtml += `<button class="${i === currentPage ? 'bg-blue-500 text-white' : 'bg-white text-blue-500 hover:bg-blue-500 hover:text-white'} border border-blue-500 rounded px-4 py-2" onclick="cargarReservas('', ${i})">${i}</button>`;
    }
    paginationHtml += '</div>';
    $('#pagination').html(paginationHtml);
}

$('#searchBox').keyup(function() {
    let searchTerm = $(this).val();
    cargarReservas(searchTerm);
});

cargarReservas(); // Cargar inicialmente todas las reservas



</script> <!-- Asegúrate de que el path al archivo JS es correcto -->

    <!-- Incluir script de AJAX y script personalizado para reservas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
