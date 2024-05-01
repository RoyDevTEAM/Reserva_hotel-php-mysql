<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Hotel Services</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<?php include_once '../template_cliente/header.php'; ?>

   <!-- Sección de Portada -->
<div class="relative w-full h-screen bg-cover bg-center" style="background-image: url('https://images7.alphacoders.com/362/362619.jpg');">
    <div class="flex items-center justify-center h-full">
        <div class="text-center text-white">
            <h1 class="text-6xl font-bold">Bienvenido a Hotel Services</h1>
            <p class="text-xl mt-4">Tu escapada perfecta empieza aquí</p>
            <a href="/hotel_ajax/public/reserva.php" class="mt-8 inline-block bg-green-500 text-white py-3 px-6 rounded-lg text-lg hover:bg-green-600 transition duration-300">Ir a Reserva</a>
        </div>
    </div>
</div>


  <!-- Sección Sobre Nosotros -->
<div class="bg-white py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center">Sobre Nosotros</h2>
        <p class="text-lg text-gray-600 mt-4 text-center">Descubre más sobre nuestra historia y lo que nos hace únicos.</p>
        
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
            <div>
                <img src="https://c4.wallpaperflare.com/wallpaper/596/810/493/5c1ce153869dc-wallpaper-preview.jpg" alt="Hotel Services Exterior" class="rounded-lg shadow-lg">
            </div>
            <div>
                <h3 class="text-2xl font-semibold">Un Oasis Urbano en el Corazón de Santa Cruz</h3>
                <p class="mt-4 text-gray-600">Ubicados en la zona de la Virgen de Luján, noveno anillo, nuestros servicios están diseñados para ofrecer una experiencia excepcional en uno de los sectores más exclusivos de Santa Cruz de la Sierra.</p>
                <p class="mt-2 text-gray-600">Fundado por Roider Millares, nuestro hotel se distingue por una arquitectura impresionante y un servicio personalizado que garantiza una estadía memorable a cada uno de nuestros huéspedes.</p>
                <p class="mt-2 text-gray-600">En Hotel Services, combinamos confort y lujo para crear un refugio perfecto tanto para viajeros de negocios como para turistas en busca de relajación.</p>
            </div>
        </div>
    </div>
</div>

  <!-- Sección de Habitaciones y Servicios -->
<div class="container mx-auto px-4 py-16">
    <h2 class="text-4xl font-bold text-center">Habitaciones y Servicios</h2>
    
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Tarjetas de Habitaciones -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="https://c.wallhere.com/photos/c7/41/rooms_furniture_design_interior_modern-643201.jpg!d" alt="Habitación Estándar" class="w-full object-cover" style="height: 200px;">
            <div class="p-4">
                <h3 class="font-bold text-xl">Habitación Estándar</h3>
                <p class="text-gray-600">Una habitación simple con 1 cama doble, ideal para viajeros individuales o parejas.</p>
                <p class="text-green-600 font-bold">$50.00/noche</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="https://estudiohorizon.files.wordpress.com/2010/08/habitacic3b3n-de-hotel-5-estrellas-i-1.jpg" alt="Habitación Doble" class="w-full object-cover" style="height: 200px;">
            <div class="p-4">
                <h3 class="font-bold text-xl">Habitación Doble</h3>
                <p class="text-gray-600">Habitación doble con 2 camas individuales, perfecta para amigos o colegas.</p>
                <p class="text-green-600 font-bold">$75.00/noche</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="https://c.wallhere.com/photos/9f/2c/couch_tripod_lamp_interior_modern-229719.jpg!d" alt="Suite" class="w-full object-cover" style="height: 200px;">
            <div class="p-4">
                <h3 class="font-bold text-xl">Suite</h3>
                <p class="text-gray-600">Suite de lujo con jacuzzi y vista al mar, para una experiencia inolvidable.</p>
                <p class="text-green-600 font-bold">$150.00/noche</p>
            </div>
        </div>
    </div>

    <!-- Descripción de Servicios -->
    <h3 class="text-3xl font-bold text-center mt-16 mb-8">Servicios Adicionales</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-center">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h4 class="font-bold text-lg">Desayuno</h4>
            <p class="text-gray-600 mt-2">Desayuno continental incluido.</p>
            <p class="text-green-600 font-bold">$10.00</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h4 class="font-bold text-lg">Gimnasio</h4>
            <p class="text-gray-600 mt-2">Acceso al gimnasio 24 horas.</p>
            <p class="text-green-600 font-bold">$15.00</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h4 class="font-bold text-lg">Spa</h4>
            <p class="text-gray-600 mt-2">Servicios de spa y masajes.</p>
            <p class="text-green-600 font-bold">$40.00</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h4 class="font-bold text-lg">Parqueadero</h4>
            <p class="text-gray-600 mt-2">Parqueadero exclusivo para huéspedes.</p>
            <p class="text-green-600 font-bold">$5.00</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h4 class="font-bold text-lg">Lavandería</h4>
            <p class="text-gray-600 mt-2">Servicio de lavandería diario.</p>
            <p class="text-green-600 font-bold">$20.00</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h4 class="font-bold text-lg">Lavandería</h4>
            <p class="text-gray-600 mt-2">Servicio de lavandería diario.</p>
            <p class="text-green-600 font-bold">$20.00</p>
        </div>
    </div>
</div>
<!-- Sección de Comentarios de Clientes -->
<div class="bg-gray-100 py-16">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-12">Comentarios de Nuestros Clientes</h2>
        <div class="flex flex-wrap justify-center gap-8">
            <!-- Comentario 1 -->
            <div class="w-full md:w-1/3 bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <img src="https://i.pravatar.cc/150?img=12" alt="Perfil de usuario" class="w-12 h-12 rounded-full mr-3">
                    <div>
                        <h5 class="font-bold">Ana González</h5>
                        <p class="text-gray-500 text-sm">Cliente frecuente</p>
                    </div>
                </div>
                <p class="text-gray-600">"La atención es maravillosa y las habitaciones siempre están impecables. ¡Siempre recomiendo este hotel a todos mis amigos!"</p>
                <div class="flex mt-4">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
            </div>

            <!-- Comentario 2 -->
            <div class="w-full md:w-1/3 bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <img src="https://i.pravatar.cc/150?img=32" alt="Perfil de usuario" class="w-12 h-12 rounded-full mr-3">
                    <div>
                        <h5 class="font-bold">Jorge Martínez</h5>
                        <p class="text-gray-500 text-sm">Viajero de negocios</p>
                    </div>
                </div>
                <p class="text-gray-600">"Ideal para mis viajes de trabajo. El internet es rápido y el servicio de habitaciones es muy eficiente."</p>
                <div class="flex mt-4">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star-half-alt text-yellow-400"></i>
                </div>
            </div>

            <!-- Comentario 3 -->
            <div class="w-full md:w-1/3 bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <img src="https://i.pravatar.cc/150?img=45" alt="Perfil de usuario" class="w-12 h-12 rounded-full mr-3">
                    <div>
                        <h5 class="font-bold">Luisa Fernanda</h5>
                        <p class="text-gray-500 text-sm">Turista</p>
                    </div>
                </div>
                <p class="text-gray-600">"¡Un oasis en la ciudad! El spa es increíble y los jardines son un lugar perfecto para relajarse después de un día de turismo."</p>
                <div class="flex mt-4">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
            </div>
              <!-- Comentario 3 -->
              <div class="w-full md:w-1/3 bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <img src="https://i.pravatar.cc/150?img=45" alt="Perfil de usuario" class="w-12 h-12 rounded-full mr-3">
                    <div>
                        <h5 class="font-bold">Luisa Fernanda</h5>
                        <p class="text-gray-500 text-sm">Turista</p>
                    </div>
                </div>
                <p class="text-gray-600">"¡Un oasis en la ciudad! El spa es increíble y los jardines son un lugar perfecto para relajarse después de un día de turismo."</p>
                <div class="flex mt-4">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Sección de Contacto -->
  
    <?php include_once '../template_cliente/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
</body>
</html>
