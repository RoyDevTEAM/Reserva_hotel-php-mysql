$(document).ready(function() {
    fetchServices();

    function fetchServices() {
        $.ajax({
            url: '/hotel_ajax/functions/servicio.php',
            type: 'POST',
            data: { action: 'get_servicios' },
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data.length > 0) {
                    var servicesHtml = '';
                    response.data.forEach(function(service) {
                        servicesHtml += `
                            <div class="w-full md:w-1/3 p-4">
                                <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                                    <img src="${service.imagen || 'https://via.placeholder.com/150'}" alt="${service.nombre}" class="w-full h-64 object-cover">
                                    <div class="p-4">
                                        <h3 class="font-bold text-xl">${service.nombre}</h3>
                                        <p class="text-gray-600 mt-2">${service.descripcion}</p>
                                        <p class="text-gray-800 mt-2">$${parseFloat(service.precio).toFixed(2)}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    $('#services-container').html(servicesHtml);
                } else {
                    $('#services-container').html('<div class="text-center text-gray-800 w-full">No se encontraron servicios disponibles.</div>');
                }
            },
            error: function(xhr, status, error) {
                $('#services-container').html('<div class="text-center text-gray-800 w-full">Error al cargar los servicios. Por favor, inténtelo de nuevo más tarde.</div>');
                console.error('Error fetching services:', xhr.responseText);
            }
        });
    }
});
