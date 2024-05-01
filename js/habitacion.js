$(document).ready(function() {
    function cargarHabitaciones(searchTerm = '') {
        $.ajax({
            url: '../../functions/habitacion.php',
            type: 'POST',
            data: {
                action: 'get_habitaciones',
                searchTerm: searchTerm
            },
            dataType: 'json',
            success: function(response) {
                let html = '<table class="min-w-full leading-normal">';
                html += '<thead>';
                html += '<tr>';
                html += '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Número</th>';
                html += '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipo</th>';
                html += '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>';
                html += '</tr>';
                html += '</thead>';
                html += '<tbody>';
                response.forEach(function(hab) {
                    html += '<tr>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">' + hab.numero + '</td>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">' + hab.tipo_habitacion + '</td>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">';
                    html += '<a href="#" onclick="editarHabitacion(' + hab.id_habitacion + ')" class="text-blue-600 hover:text-blue-900"><i class="fas fa-edit"></i></a>';
                    html += '<a href="#" onclick="eliminarHabitacion(' + hab.id_habitacion + ')" class="text-red-600 hover:text-red-900 ml-3"><i class="fas fa-trash"></i></a>';
                    html += '</td>';
                    html += '</tr>';
                });
                html += '</tbody>';
                html += '</table>';
                $('#habitacionesContainer').html(html);
            },
            error: function() {
                alert('Error al cargar las habitaciones.');
            }
        });
    }

    $('#searchBox').keyup(function() {
        let searchTerm = $(this).val();
        cargarHabitaciones(searchTerm);
    });

    window.eliminarHabitacion = function(id_habitacion) {
        swal({
            title: "¿Estás seguro?",
            text: "Si la habitación está reservada, no se podrá eliminar. ¿Deseas continuar?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: '../../functions/habitacion.php',
                    type: 'POST',
                    data: {
                        action: 'delete_habitacion',
                        id_habitacion: id_habitacion
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            swal("¡La habitación ha sido eliminada!", {
                                icon: "success",
                            }).then(() => {
                                cargarHabitaciones($('#searchBox').val());
                            });
                        } else {
                            // Aquí se maneja el caso en que la habitación no pueda ser eliminada porque está vinculada a reservas activas
                            swal("Error al eliminar la habitación.", {
                                icon: "error",
                                text: response.message, // Muestra el mensaje de error del servidor
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Aquí se maneja el caso de un error en la petición AJAX como tal
                        swal("Error al intentar eliminar la habitación.", {
                            icon: "error",
                            text: "Error del servidor: " + xhr.responseText, // Se utiliza xhr.responseText para obtener la respuesta del servidor
                        });
                    }
                });
            }
        });
    };
    const idHabitacion = new URLSearchParams(window.location.search).get('id');
    if (idHabitacion) {
        cargarDatosHabitacion(idHabitacion);
    }

    function cargarDatosHabitacion(idHabitacion) {
        $.ajax({
            url: '../../functions/habitacion.php',
            type: 'POST',
            data: { action: 'get_habitacion_by_id', id_habitacion: idHabitacion },
            dataType: 'json',
            success: function(habitacion) {
                // Aquí rellenamos el formulario con los datos recibidos
                $('#id_habitacion').val(habitacion.id_habitacion);
                $('#numero').val(habitacion.numero);
                $('#tipo_habitacion').val(habitacion.tipo_habitacion);
                $('#descripcion').val(habitacion.descripcion);
                $('#capacidad').val(habitacion.capacidad);
                $('#precio_noche').val(habitacion.precio_noche);
                $('#estado').val(habitacion.estado);
            },
            error: function(xhr) {
                swal("Error", "No se pudo cargar la información de la habitación. Error: " + xhr.responseText, "error");
            }
        });
    }

    $('#formEditarHabitacion').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '../../functions/habitacion.php',
            type: 'POST',
            data: $(this).serialize() + '&action=update_habitacion',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    swal("¡Éxito!", "La habitación ha sido actualizada correctamente.", "success").then(() => {
                        window.location.href = 'index.php'; // Redirección a la página principal
                    });
                } else {
                    swal("Error", response.message, "error");
                }
            },
            error: function(xhr) {
                swal("Error", "Error al actualizar la habitación: " + xhr.responseText, "error");
            }
        });
    });
    $('#formCrearHabitacion').submit(function(e) {
        e.preventDefault(); // Previene el envío tradicional del formulario
    
        $.ajax({
            url: '../../functions/habitacion.php',
            type: 'POST',
            data: $(this).serialize() + '&action=create_habitacion',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    swal("¡Habitación creada!", {
                        icon: "success",
                    }).then(() => {
                        window.location.href = 'index.php'; // Redirige a la página de índice de habitaciones
                    });
                } else {
                    swal("Error al crear la habitación", {
                        icon: "error",
                        text: response.message,
                    });
                }
            },
            error: function(xhr, status, error) {
                swal("Error al intentar crear la habitación", {
                    icon: "error",
                    text: "Error del servidor: " + xhr.responseText,
                });
            }
        });
    });
    
    window.editarHabitacion = function(id_habitacion) {
        location.href = 'editar.php?id=' + id_habitacion; // Redirige a la página de edición
    };
    cargarHabitaciones(); // Cargar inicialmente todas las habitaciones
});
