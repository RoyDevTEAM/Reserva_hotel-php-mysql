$(document).ready(function() {
    // Carga inicial de servicios y métodos de pago
    cargarServicios();
    cargarMetodosPago();

    $('#inputCliente').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '/hotel_ajax/functions/procesaReservaadmin.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'buscarClientes',
                    nombre: request.term
                },
                success: function(data) {
                    if(data.success) {
                        response($.map(data.clientes, function(item) {
                            return {
                                label: item.nombre + ' ' + item.apellido,
                                value: item.id_usuario
                            };
                        }));
                    }
                },
                error: function() {
                    Swal.fire('Error', 'No se pudo obtener la respuesta del servidor', 'error');
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $('#inputCliente').val(ui.item.label); // muestra el nombre en el campo de texto
            $('#inputCliente').val(ui.item.value); // guarda el ID del cliente seleccionado
            updateResumen('cliente', ui.item.label); // Actualiza la tarjeta de resumen
            return false;
        }
    });

    $('#fechaEntrada, #fechaSalida').on('change', function() {
        var fechaEntrada = $('#fechaEntrada').val();
        var fechaSalida = $('#fechaSalida').val();
        if (fechaEntrada && fechaSalida) {
            $.ajax({
                url: '/hotel_ajax/functions/procesaReservaadmin.php',
                type: 'POST',
                data: {
                    action: 'verificarDisponibilidad',
                    fecha_entrada: fechaEntrada,
                    fecha_salida: fechaSalida
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        $('#tipoHabitacion').empty().append('<option>Seleccione una habitación</option>');
                        data.habitaciones.forEach(function(habitacion) {
                            $('#tipoHabitacion').append(`<option value="${habitacion.id_habitacion}">${habitacion.numero} - ${habitacion.tipo_habitacion}</option>`);
                        });
                        $('#tipoHabitacion').removeAttr('disabled');
                    } else {
                        Swal.fire('Error', 'No se pudo cargar las habitaciones disponibles', 'error');
                    }
                }
            });
        }
    });

    // Calcular el costo total de la reserva
    $('#tipoHabitacion').on('change', function() {
        var idHabitacion = $(this).val();
        var fechaEntrada = $('#fechaEntrada').val();
        var fechaSalida = $('#fechaSalida').val();
        if (idHabitacion) {
            $.ajax({
                url: '/hotel_ajax/functions/procesaReservaadmin.php',
                type: 'POST',
                data: { action: 'calcularCostoTotal', id_habitacion: idHabitacion, fecha_entrada: fechaEntrada, fecha_salida: fechaSalida },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        $('#costoTotal').text(`Costo Total: $${data.costo_total.toFixed(2)}`);
                        updateResumen('habitacion', $('#tipoHabitacion option:selected').text());
                        updateResumen('fechas', `Del ${fechaEntrada} al ${fechaSalida}`);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                }
            });
        }
    });

    // Sumar servicios extras al costo total
    $('#btnSumarServicios').on('click', function() {
        var costoBase = parseFloat($('#costoTotal').text().replace('Costo Total: $', ''));
        var costoExtra = 0;
        var serviciosSeleccionados = [];
        $('input[name="serviciosExtras"]:checked').each(function() {
            costoExtra += parseFloat($(this).data('precio'));
            serviciosSeleccionados.push($(this).next('label').text());
        });
        $('#costoTotal').text(`Costo Total: $${(costoBase + costoExtra).toFixed(2)}`);
        updateResumen('servicios', serviciosSeleccionados.join(', '));
    });
    $('#btnReservar').on('click', function() {
        var idUsuario = $('#inputCliente').val(); // Asegúrate de que este elemento contiene el valor correcto
        var idHabitacion = $('#tipoHabitacion').val();
        var fechaEntrada = $('#fechaEntrada').val();
        var fechaSalida = $('#fechaSalida').val();
        var costoTotal = parseFloat($('#costoTotal').text().replace('Costo Total: $', ''));
        var metodoPago = $('#metodoPago').val();
        var serviciosSeleccionados = $('input[name="serviciosExtras"]:checked').map(function() {
            return this.id.replace('servicio', '');
        }).get();
    
        if (!idUsuario || !idHabitacion || !fechaEntrada || !fechaSalida || !metodoPago || isNaN(costoTotal)) {
            Swal.fire('Error', 'Por favor, completa todos los campos necesarios.', 'error');
            return;
        }
    
        $.ajax({
            url: '/hotel_ajax/functions/procesaReservaadmin.php',
            type: 'POST',
            data: {
                action: 'realizarReserva',
                id_usuario: idUsuario,
                id_habitacion: idHabitacion,
                fecha_entrada: fechaEntrada,
                fecha_salida: fechaSalida,
                costo_total: costoTotal,
                metodo_pago: metodoPago,
                servicios: serviciosSeleccionados
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Reserva completada',
                        text: 'La reserva se ha realizado con éxito.',
                        footer: '<a href="ver_reserva.html">Ver Detalles de la Reserva</a> | <a href="factura/factura.php">Imprimir Factura</a>',
                        showCancelButton: true,
                        confirmButtonText: 'Ir a Detalles',
                        cancelButtonText: 'Cerrar',
                        showLoaderOnConfirm: true
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = 'ver_reserva.html';
                        }
                    });
                }  else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al reservar',
                        text: data.message
                    });
                }
            },
            error: function() {
                Swal.fire('Error', 'Hubo un problema con la petición al servidor.', 'error');
            }
        });
    });
    
    
    
});

// Funciones adicionales para cargar servicios y métodos de pago
function cargarServicios() {
    $.ajax({
        url: '/hotel_ajax/functions/procesaReservaadmin.php',
        type: 'POST',
        data: { action: 'traerServicios' },
        success: function(response) {
            var data = JSON.parse(response);
            if (data.success) {
                data.servicios.forEach(function(servicio) {
                    $('#serviciosExtras').append(
                        `<div><input type="checkbox" name="serviciosExtras" id="servicio${servicio.id_servicio}" data-precio="${servicio.precio}">
                         <label for="servicio${servicio.id_servicio}">${servicio.nombre} - $${servicio.precio}</label></div>`
                    );
                });
            }
        }
    });
}

function cargarMetodosPago() {
    $.ajax({
        url: '/hotel_ajax/functions/procesaReservaadmin.php',
        type: 'POST',
        data: { action: 'traerTiposDePago' },
        success: function(response) {
            var data = JSON.parse(response);
            if (data.success) {
                $('#metodoPago').empty();  // Limpia el select antes de agregar nuevos elementos
                data.metodos_pago.forEach(function(metodo) {
                    $('#metodoPago').append(`<option>${metodo}</option>`);
                });
                updateResumen('pago', $('#metodoPago option:selected').text());  // Actualiza el resumen inicialmente con el primer método de pago
            }
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar métodos de pago: " + error);
        }
    });

    // Añade el manejador del evento 'change' fuera de la llamada AJAX para asegurarse de que se establezca una sola vez
    $('#metodoPago').on('change', function() {
        updateResumen('pago', $('#metodoPago option:selected').text());
    });
}


function updateResumen(field, value) {
    switch(field) {
        case 'cliente':
            $('#resumenCliente span').text(value);
            break;
        case 'fechas':
            $('#resumenFechas span').text(value);
            break;
        case 'habitacion':
            $('#resumenHabitacion span').text(value);
            break;
        case 'servicios':
            $('#resumenServicios span').text(value);
            break;
        case 'pago':
            $('#resumenPago span').text(value);
            break;
    }
}
