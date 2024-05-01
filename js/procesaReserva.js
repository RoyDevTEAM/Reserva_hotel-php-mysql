$(document).ready(function() {
    // Cargar servicios desde el servidor
    function loadServices() {
        $.getJSON('/hotel_ajax/functions/traerServicioPago.php', {type: 'servicios'}, function(response) {
            if (response.success) {
                var servicesSelect = $('#id_servicio');
                servicesSelect.empty(); // Limpiar opciones anteriores
                response.servicios.forEach(function(servicio) {
                    servicesSelect.append(new Option(servicio.nombre + ' - $' + servicio.precio, servicio.id_servicio));
                });
            } else {
                console.error('Error cargando los servicios: ', response.message);
            }
        });
    }

    // Cargar métodos de pago desde el servidor
    function loadPaymentMethods() {
        $.getJSON('/hotel_ajax/functions/traerServicioPago.php', {type: 'metodos_pago'}, function(response) {
            if (response.success) {
                var paymentSelect = $('#metodo_pago');
                paymentSelect.empty(); // Limpiar opciones anteriores
                response.metodos_pago.forEach(function(metodo) {
                    paymentSelect.append(new Option(metodo.nombre, metodo.id));
                });
            } else {
                console.error('Error cargando los métodos de pago: ', response.message);
            }
        });
    }

    // Inicializar la carga de datos
    loadServices();
    loadPaymentMethods();

    $('#addServiceForm').submit(function(event) {
        event.preventDefault();
        var idReserva = $('#id_reserva').val();
        var idServicio = $('#id_servicio').val();
    
        $.ajax({
            url: '/hotel_ajax/functions/procesaReserva.php',
            type: 'POST',
            data: {
                action: 'add_service_to_reservation',
                id_reserva: idReserva,
                id_servicio: idServicio
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#display_costo_total').text('$' + response.nuevo_costo_total.toFixed(2));  // Actualizar monto visual en página
                    $('#monto').val(response.nuevo_costo_total);  // Actualizar valor del input oculto
                    swal("¡Éxito!", response.message + " Nuevo costo total: $" + response.nuevo_costo_total, "success");
                } else {
                    swal("Error", response.message, "error");
                }
            },
            error: function() {
                swal("Error", "No se pudo procesar la solicitud. Intente de nuevo.", "error");
            }
        });
    });
    
// Evento para finalizar la reserva y procesar el pago
$('#finalizeReservationForm').submit(function(event) {
    event.preventDefault();
    var idReserva = $('#id_reserva').val();
    var metodoPago = $('#metodo_pago').val();
    var monto = $('#monto').val(); // Utilizar el valor actualizado del monto

    if (!monto) {
        swal("Error", "Debe especificar un monto para proceder con el pago.", "error");
        return;
    }

    $.ajax({
        url: '/hotel_ajax/functions/procesaReserva.php',
        type: 'POST',
        data: {
            action: 'finalize_reservation',
            id_reserva: idReserva,
            metodo_pago: metodoPago,
            monto: monto
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                swal("¡Reserva Completada!", response.message, "success").then(() => {
                    window.location.href = `/hotel_ajax/public/pago.php?id_reserva=${idReserva}&monto=${monto}&metodo_pago=${metodoPago}`;
                });
            } else {
                swal("Error", response.message, "error");
            }
        },
        error: function() {
            swal("Error", "No se pudo procesar el pago. Por favor, intente nuevamente.", "error");
        }
    });
});
});
