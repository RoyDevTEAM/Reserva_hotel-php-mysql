$(document).ready(function() {
    function cargarReservas(searchTerm = '') {
        $.ajax({
            url: '../../functions/reserva.php',
            type: 'POST',
            data: {
                action: 'get_reservas',
                searchTerm: searchTerm
            },
            dataType: 'json',
            success: function(response) {
                let html = '<table class="min-w-full leading-normal">';
                html += '<thead>';
                html += '<tr>';
                html += '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Cliente</th>';
                html += '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Habitación</th>';
                html += '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha Entrada</th>';
                html += '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha Salida</th>';
                html += '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Costo Total</th>';
                html += '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado</th>';
                html += '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>';
                html += '</tr>';
                html += '</thead>';
                html += '<tbody>';
                response.data.forEach(function(reserva) {
                    html += '<tr>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">' + reserva.nombre_cliente + ' ' + reserva.apellido_cliente + '</td>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">' + reserva.numero_habitacion + ' (' + reserva.tipo_habitacion + ')</td>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">' + reserva.fecha_entrada + '</td>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">' + reserva.fecha_salida + '</td>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">' + reserva.costo_total + '</td>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">' + reserva.estado_reserva + '</td>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">';
                    html += '<a href="#" onclick="editarReserva(' + reserva.id_reserva + ')" class="text-blue-600 hover:text-blue-900"><i class="fas fa-edit"></i></a>';
                    html += '<a href="#" onclick="eliminarReserva(' + reserva.id_reserva + ')" class="text-red-600 hover:text-red-900 ml-3"><i class="fas fa-trash"></i></a>';
                    if (reserva.estado_reserva === "Pendiente") {
                        html += '<button onclick="confirmarReserva(' + reserva.id_reserva + ')" class="ml-3 text-green-600 hover:text-green-900">Confirmar</button>';
                    }
                    html += '<a href="factura/factura.php?id=' + reserva.id_reserva + '" class="ml-3 text-indigo-600 hover:text-indigo-900"><i class="fas fa-print"></i> Imprimir</a>';
                    html += '</td>';
                    html += '</tr>';
                });
                html += '</tbody>';
                html += '</table>';
                $('#reservasContainer').html(html);
            },
            error: function() {
                alert('Error al cargar las reservas.');
            }
        });
    }

    $('#searchBox').keyup(function() {
        let searchTerm = $(this).val();
        cargarReservas(searchTerm);
    });

    window.editarReserva = function(id_reserva) {
        location.href = 'editar.php?id=' + id_reserva; // Redirige a la página de edición
    };

    window.eliminarReserva = function(id_reserva) {
        swal({
            title: "¿Estás seguro?",
            text: "Esta acción es irreversible.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
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
                            swal("¡La reserva ha sido eliminada!", {
                                icon: "success",
                            }).then(() => {
                                cargarReservas($('#searchBox').val());
                            });
                        } else {
                            swal("Error al eliminar la reserva.", {
                                icon: "error",
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        swal("Error al intentar eliminar la reserva.", {
                            icon: "error",
                            text: "Error del servidor: " + xhr.responseText,
                        });
                    }
                });
            }
        });
    };

    window.confirmarReserva = function(id_reserva) {
        // Implementación de la confirmación de la reserva
        $.ajax({
            url: '../../functions/reserva.php',
            type: 'POST',
            data: {
                action: 'confirm_reserva',
                id_reserva: id_reserva
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    swal("Reserva confirmada con éxito!", {
                        icon: "success",
                    }).then(() => {
                        cargarReservas($('#searchBox').val());
                    });
                } else {
                    swal("Error al confirmar la reserva.", {
                        icon: "error",
                        text: response.message,
                    });
                }
            },
            error: function() {
                swal("Error al intentar confirmar la reserva.", {
                    icon: "error",
                });
            }
        });
    };

    cargarReservas(); // Cargar inicialmente todas las reservas
});
