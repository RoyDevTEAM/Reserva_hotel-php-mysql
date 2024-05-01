<?php
session_start();  // Iniciar sesión en cada script que use sesión

// Verificar si el usuario está logueado y tiene el tipo de usuario correcto
if (!isset($_SESSION['tipo_usuario']) || ($_SESSION['tipo_usuario'] != 'empleado' && $_SESSION['tipo_usuario'] != 'admin')) {
    // Incluir SweetAlert para mostrar mensajes elegantes
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
    echo "<script type='text/javascript'>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Acceso Restringido',
                    text: 'Debes iniciar sesión como empleado o administrador para acceder a esta página.',
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/hotel_ajax/sesion/login.php';
                    }
                });
            });
          </script>";
    exit;  // Detener la ejecución del script
}
?>
