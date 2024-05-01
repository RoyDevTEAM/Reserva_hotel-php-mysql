const idHabitacion = new URLSearchParams(window.location.search).get('id');
if (idHabitacion) {
    cargarDatosHabitacion(idHabitacion);
}

function cargarDatosHabitacion(idHabitacion) {
    $.ajax({
        url: '../../functions/habitacion.php',
        type: 'POST',
        data: { action: 'get_habitacion_by_id', id_habitacion: idHabitacion },
        dataType: 'json',
        success: function(habitacion) {
            if (habitacion) {
                $('#formEditarHabitacion').html(`
                    <input type="hidden" name="id_habitacion" value="${habitacion.id_habitacion}">
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="numero">Número</label>
                            <input type="text" name="numero" id="numero" value="${habitacion.numero}" required class="appearance-none block w-full bg-gray-200 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 rounded">
                        </div>
                        <div class="w-full md:w-1/2 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="tipo_habitacion">Tipo de Habitación</label>
                            <input type="text" name="tipo_habitacion" id="tipo_habitacion" value="${habitacion.tipo_habitacion}" required class="appearance-none block w-full bg-gray-200 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 rounded">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="descripcion">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="appearance-none block w-full bg-gray-200 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 rounded" style="min-height: 100px;">${habitacion.descripcion}</textarea>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="capacidad">Capacidad</label>
                            <input type="number" name="capacidad" id="capacidad" value="${habitacion.capacidad}" required class="appearance-none block w-full bg-gray-200 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 rounded">
                        </div>
                        <div class="w-full md:w-1/2 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="precio_noche">Precio por Noche ($)</label>
                            <input type="text" name="precio_noche" id="precio_noche" value="${habitacion.precio_noche}" required class="appearance-none block w-full bg-gray-200 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 rounded">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="estado">Estado</label>
                            <select name="estado" id="estado" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                <option value="disponible" ${habitacion.estado === 'disponible' ? 'selected' : ''}>Disponible</option>
                                <option value="ocupada" ${habitacion.estado === 'ocupada' ? 'selected' : ''}>Ocupada</option>
                                <option value="mantenimiento" ${habitacion.estado === 'mantenimiento' ? 'selected' : ''}>En Mantenimiento</option>
                                <option value="limpieza" ${habitacion.estado === 'limpieza' ? 'selected' : ''}>En Limpieza</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            <i class="fas fa-save mr-2"></i>Guardar Cambios
                        </button>
                        <button onclick="window.location.href='index.php'" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </button>
                    </div>
                `);
            } else {
                swal("Error", "No se encontraron datos para la habitación especificada.", "error");
            }
        },
        error: function(xhr) {
            swal("Error", "Error al cargar los datos: " + xhr.responseText, "error");
        }
    });
}