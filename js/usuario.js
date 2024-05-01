$(document).ready(function() {
    function cargarUsuarios(searchTerm = '') {
        $.ajax({
            url: '../../functions/usuario.php',
            type: 'POST',
            data: {
                action: 'get_usuarios',
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
                html += '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipo de Usuario</th>';
                html += '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>';
                html += '</tr>';
                html += '</thead>';
                html += '<tbody>';
                response.forEach(function(usuario) {
                    html += '<tr>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">' + usuario.nombre + '</td>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">' + usuario.apellido + '</td>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">' + usuario.email + '</td>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">' + usuario.tipo_usuario + '</td>';
                    html += '<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">';
                    html += '<a href="#" onclick="editarUsuario(' + usuario.id_usuario + ')" class="text-blue-600 hover:text-blue-900"><i class="fas fa-edit"></i></a>';
                    html += '<a href="#" onclick="eliminarUsuario(' + usuario.id_usuario + ')" class="text-red-600 hover:text-red-900 ml-3"><i class="fas fa-trash"></i></a>';
                    html += '</td>';
                    html += '</tr>';
                });
                html += '</tbody>';
                html += '</table>';
                $('#usuariosContainer').html(html);
            },
            error: function() {
                alert('Error al cargar los usuarios.');
            }
        });
    }

    $('#searchBox').keyup(function() {
        let searchTerm = $(this).val();
        cargarUsuarios(searchTerm);
    });

    window.eliminarUsuario = function(id_usuario) {
        swal({
            title: "¿Estás seguro?",
            text: "¿Deseas continuar con la eliminación del usuario?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: '../../functions/usuario.php',
                    type: 'POST',
                    data: {
                        action: 'delete_usuario',
                        id_usuario: id_usuario
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            swal("¡El usuario ha sido eliminado!", {
                                icon: "success",
                            }).then(() => {
                                cargarUsuarios($('#searchBox').val());
                            });
                        } else {
                            swal("Error al eliminar el usuario.", {
                                icon: "error",
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        swal("Error al intentar eliminar el usuario.", {
                            icon: "error",
                            text: "Error del servidor: " + xhr.responseText,
                        });
                    }
                });
            }
        });
    };
    $('#formCrearUsuario').submit(function(e) {
        e.preventDefault(); // Previene el envío tradicional del formulario

        // Realizar la petición AJAX para crear un nuevo usuario
        $.ajax({
            url: '../../functions/usuario.php', // Asegúrate de que la ruta es correcta
            type: 'POST',
            data: $(this).serialize() + '&action=create_usuario', // Añade la acción para el manejo en PHP
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Mostrar notificación de éxito y redireccionar
                    swal("¡Usuario Creado!", "El usuario fue creado exitosamente.", "success")
                    .then(() => {
                        window.location.href = 'index.php'; // Redirige al índice de usuarios
                    });
                } else {
                    // Mostrar error si la creación no es exitosa
                    swal("Error al crear usuario", {
                        icon: "error",
                        text: response.message,
                    });
                }
            },
            error: function(xhr, status, error) {
                // Manejo de errores de la petición AJAX
                swal("Error", "No se pudo crear el usuario: " + xhr.responseText, "error");
            }
        });
    });
    window.editarUsuario = function(id_usuario) {
        location.href = 'editar.php?id=' + id_usuario; // Redirige a la página de edición
    };
  // Cargar los datos del usuario cuando la página carga
  const idUsuario = new URLSearchParams(window.location.search).get('id');
  if (idUsuario) {
      cargarDatosUsuario(idUsuario);
  }

  // Función para cargar los datos del usuario en el formulario de edición
  function cargarDatosUsuario(idUsuario) {
      $.ajax({
          url: '../../functions/usuario.php',
          type: 'POST',
          data: {
              action: 'get_usuario_by_id',
              id_usuario: idUsuario
          },
          dataType: 'json',
          success: function(usuario) {
              if (usuario) {
                  $('#id_usuario').val(usuario.id_usuario);
                  $('#nombre').val(usuario.nombre);
                  $('#apellido').val(usuario.apellido);
                  $('#email').val(usuario.email);
                  $('#telefono').val(usuario.telefono);
                  $('#direccion').val(usuario.direccion);
                  $('#tipo_usuario').val(usuario.tipo_usuario);
                  $('#contraseña').val(''); // Limpiar el campo contraseña por seguridad
              } else {
                  swal("Error", "No se encontraron datos del usuario.", "error");
              }
          },
          error: function(xhr) {
              swal("Error", "Error al cargar la información del usuario: " + xhr.responseText, "error");
          }
      });
  }

  // Manejo del evento submit del formulario de edición
  $('#formEditarUsuario').on('submit', function(e) {
      e.preventDefault();
      let formData = $(this).serialize() + '&action=update_usuario';

      $.ajax({
          url: '../../functions/usuario.php',
          type: 'POST',
          data: formData,
          dataType: 'json',
          success: function(response) {
              if (response.success) {
                  swal("¡Éxito!", "El usuario ha sido actualizado correctamente.", "success").then(() => {
                      window.location.href = 'index.php'; // Redirige a la página de listado de usuarios
                  });
              } else {
                  swal("Error", response.message, "error");
              }
          },
          error: function(xhr) {
              swal("Error", "Error al actualizar el usuario: " + xhr.responseText, "error");
          }
      });
  });
    cargarUsuarios(); // Cargar inicialmente todos los usuarios
});
