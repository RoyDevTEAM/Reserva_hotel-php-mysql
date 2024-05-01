$(document).ready(function() {
    $('#checkAvailabilityButton').click(function() {
        var fechaEntrada = $('#fecha_entrada').val();
        var fechaSalida = $('#fecha_salida').val();

        $.ajax({
            url: '/hotel_ajax/functions/reservaCliente.php',
            type: 'POST',
            data: {
                action: 'check_availability',
                fecha_entrada: fechaEntrada,
                fecha_salida: fechaSalida
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    displayAvailableRooms(response.habitaciones);
                } else {
                    alert('No se encontraron habitaciones disponibles.');
                }
            },
            error: function() {
                alert('Error al verificar la disponibilidad. Por favor, intente nuevamente.');
            }
        });
    });

    function displayAvailableRooms(habitaciones) {
        var roomsHtml = '';
        habitaciones.forEach(function(habitacion) {
            var precioNoche = parseFloat(habitacion.precio_noche);
            roomsHtml += `
                <div class="room-card bg-white p-4 shadow-lg rounded-lg">
                    <img src="${habitacion.imagen}" alt="${habitacion.tipo_habitacion}" class="w-full h-48 object-cover rounded">
                    <h3 class="text-lg font-bold mt-2">${habitacion.tipo_habitacion}</h3>
                    <p>${habitacion.descripcion}</p>
                    <p class="font-semibold">Precio por noche: $${precioNoche.toFixed(2)}</p>
                    <button onclick="reservar(${habitacion.id_habitacion}, '${precioNoche}', '${habitacion.tipo_habitacion}')" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Reservar Ahora
                    </button>
                </div>
            `;
        });
        $('#availableRoomsContainer').html(roomsHtml);
    }

    window.reservar = function(idHabitacion, precioPorNoche, tipoHabitacion) {
        var fechaEntrada = $('#fecha_entrada').val();
        var fechaSalida = $('#fecha_salida').val();
        var usuarioId = localStorage.getItem('id_usuario');
        var costoTotal = calculateCost(fechaEntrada, fechaSalida, precioPorNoche);

        $.ajax({
            url: '/hotel_ajax/functions/procesaReserva.php',
            type: 'POST',
            data: {
                action: 'crear_reserva',
                id_usuario: usuarioId,
                id_habitacion: idHabitacion,
                fecha_entrada: fechaEntrada,
                fecha_salida: fechaSalida,
                costo_total: costoTotal
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    window.location.href = `/hotel_ajax/public/detalles_reserva.php?id_reserva=${response.id_reserva}&tipo_habitacion=${tipoHabitacion}&fecha_entrada=${fechaEntrada}&fecha_salida=${fechaSalida}&costo_total=${costoTotal}`;
                } else {
                    alert('Error al crear la reserva: ' + response.message);
                }
            },
            error: function() {
                alert('Error al realizar la reserva. Por favor, intente nuevamente.');
            }
        });
    };

    function calculateCost(fechaEntrada, fechaSalida, precioPorNoche) {
        var days = (new Date(fechaSalida) - new Date(fechaEntrada)) / (1000 * 3600 * 24) + 1; // Asegurarse de incluir ambas fechas
        return days * parseFloat(precioPorNoche);
    }
});
