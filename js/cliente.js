$(document).ready(function() {
    function cargarClientes(searchTerm = '') {
        $.ajax({
            url: '../../functions/cliente.php',
            type: 'POST',
            data: {
                action: 'get_clientes',
                searchTerm: searchTerm
            },
            dataType: 'json',
            success: function(response) {
                let html = '<table class="min-w-full leading-normal">';
                html += '<thead>';
                html += '<tr>';
                html += '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre</th>';
                html += '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Apellido</th>';
                html += '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>';
                html += '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>';
                html += '</tr>';
                html += '</thead>';
                html += '<tbody>';
                response.forEach(function(cliente) {
                    html += '<tr>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">' + cliente.nombre + '</td>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">' + cliente.apellido + '</td>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">' + cliente.email + '</td>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">';
                    html += '<a href="#" onclick="editarCliente(' + cliente.id_usuario + ')" class="text-blue-600 hover:text-blue-900"><i class="fas fa-edit"></i></a>';
                    html += '<a href="#" onclick="eliminarCliente(' + cliente.id_usuario + ')" class="text-red-600 hover:text-red-900 ml-3"><i class="fas fa-trash"></i></a>';
                    html += '</td>';
                    html += '</tr>';
                });
                html += '</tbody>';
                html += '</table>';
                $('#clientesContainer').html(html);
            },
            error: function() {
                alert('Error al cargar los clientes.');
            }
        });
    }

    $('#searchBox').keyup(function() {
        let searchTerm = $(this).val();
        cargarClientes(searchTerm);
    });

    window.eliminarCliente = function(id_usuario) {
        swal({
            title: "¿Estás seguro?",
            text: "¿Deseas continuar con la eliminación del cliente?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: '../../functions/cliente.php',
                    type: 'POST',
                    data: {
                        action: 'delete_cliente',
                        id_usuario: id_usuario
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            swal("¡El cliente ha sido eliminado!", {
                                icon: "success",
                            }).then(() => {
                                cargarClientes($('#searchBox').val());
                            });
                        } else {
                            swal("Error al eliminar el cliente.", {
                                icon: "error",
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        swal("Error al intentar eliminar el cliente.", {
                            icon: "error",
                            text: "Error del servidor: " + xhr.responseText,
                        });
                    }
                });
            }
        });
    };
 // Al enviar el formulario de creación de clientes
 $('#formCrearCliente').submit(function(e) {
    e.preventDefault(); // Previene el envío tradicional del formulario

    // Realizar la petición AJAX para crear un nuevo cliente
    $.ajax({
        url: '../../functions/cliente.php', // Asegúrate de que la ruta es correcta
        type: 'POST',
        data: $(this).serialize() + '&action=create_cliente',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Mostrar notificación de éxito y redireccionar
                swal("¡Cliente Creado!", "El cliente fue creado exitosamente.", "success")
                .then(() => {
                    window.location.href = 'index.php'; // Redirige al índice de clientes
                });
            } else {
                // Mostrar error si la creación no es exitosa
                swal("Error al crear cliente", {
                    icon: "error",
                    text: response.message,
                });
            }
        },
        error: function(xhr, status, error) {
            // Manejo de errores de la petición AJAX
            swal("Error", "No se pudo crear el cliente: " + xhr.responseText, "error");
        }
    });
}); const idCliente = new URLSearchParams(window.location.search).get('id');
if (idCliente) {
    cargarDatosCliente(idCliente);
}

function cargarDatosCliente(idCliente) {
    $.ajax({
        url: '../../functions/cliente.php',
        type: 'POST',
        data: { action: 'get_cliente_by_id', id_usuario: idCliente },
        dataType: 'json',
        success: function(cliente) {
            if (cliente) {
                $('#id_usuario').val(cliente.id_usuario);
                $('#nombre').val(cliente.nombre);
                $('#apellido').val(cliente.apellido);
                $('#email').val(cliente.email);
                $('#telefono').val(cliente.telefono || ''); 
                $('#direccion').val(cliente.direccion || ''); 

                // Asegurar que sea un string vacío si es null
                $('#contraseña').val(''); // Limpiar campo contraseña por seguridad
            } else {
                swal("Error", "No se encontraron datos del cliente.", "error");
            }
        },
        error: function(xhr) {
            swal("Error", "Error al cargar la información del cliente: " + xhr.responseText, "error");
        }
    });
}

$('#formEditarCliente').on('submit', function(e) {
    e.preventDefault();
    let formData = $(this).serialize() + '&action=update_cliente';

    $.ajax({
        url: '../../functions/cliente.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                swal("¡Éxito!", "El cliente ha sido actualizado correctamente.", "success").then(() => {
                    window.location.href = 'index.php'; // Redirige a la página de listado de clientes
                });
            } else {
                swal("Error", response.message, "error");
            }
        },
        error: function(xhr) {
            swal("Error", "Error al actualizar el cliente: " + xhr.responseText, "error");
        }
    });
});
    window.editarCliente = function(id_usuario) {
        location.href = 'editar.php?id=' + id_usuario; // Redirige a la página de edición
    };

    cargarClientes(); // Cargar inicialmente todos los clientes
});
