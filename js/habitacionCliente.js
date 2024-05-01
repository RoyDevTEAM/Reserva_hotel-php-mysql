$(document).ready(function() {
    fetchHabitaciones();

    function fetchHabitaciones() {
        $.ajax({
            url: '/hotel_ajax/functions/habitacionCliente.php',
            type: 'POST',
            data: { action: 'get_habitaciones' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let html = '';
                    response.data.forEach(function(habitacion) {
                        html += `
                            <div class="w-full md:w-1/3 p-4">
                                <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                                    <img src="${habitacion.imagen}" alt="Habitación ${habitacion.id_habitacion}" class="w-full h-64 object-cover">
                                    <div class="p-4">
                                        <h3 class="font-bold text-xl">${habitacion.tipo_habitacion}</h3>
                                        <p class="text-gray-600 mt-2">${habitacion.descripcion}</p>
                                        <p class="text-gray-800 mt-2">$${parseFloat(habitacion.precio_noche).toFixed(2)} por noche</p>
                                        <button class="mt-4 ${habitacion.estado === 'disponible' ? 'bg-green-500' : 'bg-red-500 cursor-not-allowed'} text-white py-2 px-4 rounded" ${habitacion.estado !== 'disponible' ? 'disabled' : ''} onclick="reservar(${habitacion.id_habitacion})">
                                            ${habitacion.estado === 'disponible' ? 'Reservar Ahora' : 'No Disponible'}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    $('#habitaciones-container').html(html);
                } else {
                    console.error('No se pudieron cargar las habitaciones:', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al fetch habitaciones:', xhr.responseText);
            }
        });
    }

    window.reservar = function(idHabitacion) {
        if (confirm('¿Desea proceder a la reserva de la habitación seleccionada?')) {
            window.location.href = `/hotel_ajax/public/reserva.php?habitacion=${idHabitacion}`;
        }
    }
});
