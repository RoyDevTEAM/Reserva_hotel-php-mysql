$(document).ready(function() {
    $('#loginForm').submit(function(event) {
        event.preventDefault();
        var username = $('#username').val();
        var password = $('#password').val();
        $.ajax({
            url: '/hotel_ajax/functions/login.php',
            type: 'POST',
            data: {
                action: 'login',
                username: username,
                password: password
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Almacenar datos en localStorage
                    localStorage.setItem('id_usuario', response.id_usuario);
                    localStorage.setItem('nombre', response.nombre);
                    localStorage.setItem('apellido', response.apellido);
                    localStorage.setItem('tipo_usuario', response.tipo_usuario);

                    // Redireccionar al usuario según su tipo
                    if (response.tipo_usuario === 'cliente') {
                        window.location.href = '/hotel_ajax/public/reserva.php';
                    } else if (response.tipo_usuario === 'empleado' || response.tipo_usuario === 'admin') {
                        window.location.href = '/hotel_ajax/empleado/dashboard.php';
                    }
                } else {
                    swal("Acceso Denegado", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                swal("Error", "Problema al intentar acceder: " + xhr.responseText, "error");
            }
        });
    });

    $('#logoutButton').click(function() {
        swal({
            title: "¿Estás seguro?",
            text: "¿Deseas cerrar la sesión?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willLogout) => {
            if (willLogout) {
                $.ajax({
                    url: '/hotel_ajax/functions/login.php',
                    type: 'POST',
                    data: { action: 'logout' },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            localStorage.clear();
                            window.location.href = '/hotel_ajax/sesion/login.php';
                            swal("Sesión cerrada", "Has cerrado sesión correctamente.", "success");
                        } else {
                            swal("Error", response.message, "error");
                        }
                    },
                    error: function() {
                        swal("Error", "Hubo un problema al procesar tu solicitud.", "error");
                    }
                });
            }
        });
    });
});
