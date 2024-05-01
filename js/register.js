$(document).ready(function() {
    $('#registerForm').submit(function(event) {
        event.preventDefault(); // Prevenir el envío normal del formulario

        var formData = $(this).serialize(); // Recolectar todos los datos del formulario

        $.ajax({
            url: '/hotel_ajax/functions/register.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(data) {
                if (data.success && data.tipo_usuario === 'cliente') { // Verifica si el registro fue exitoso y el tipo es 'cliente'
                    swal("Registro Exitoso", "¡Te has registrado satisfactoriamente!", "success")
                    .then((value) => {
                        window.location.href = '/hotel_ajax/public/reserva.php'; // Redirigir a la página de reserva
                    });
                } else {
                    swal("Error", data.message, "error");
                }
            },
            error: function() {
                swal("Error", "Hubo un problema con la solicitud", "error");
            }
        });
    });
});
