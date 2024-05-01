<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Services</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <!-- Logo -->
                    <div>
                        <a href="/hotel_ajax/public/home.php" class="flex items-center py-4 px-2">
                            <img src="https://www.macororo.com/wp-content/uploads/2019/11/MACORORO_logo_wp-300x98.png" alt="Hotel Logo" class="h-8">
                            <span class="font-semibold text-white text-lg ml-2">Hotel Services</span>
                        </a>
                    </div>
                    <!-- Primary Navbar items -->
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="/hotel_ajax/public/home.php" class="py-4 px-2 text-white font-semibold hover-gradient transition duration-300"><i class="fas fa-home pr-2"></i>Inicio</a>
                        <a href="/hotel_ajax/public/habitacion.php" class="py-4 px-2 text-white font-semibold hover-gradient transition duration-300"><i class="fas fa-bed pr-2"></i>Habitaciones</a>
                        <a href="/hotel_ajax/public/reserva.php" class="py-4 px-2 text-white font-semibold hover-gradient transition duration-300"><i class="fas fa-calendar-alt pr-2"></i>Reservar</a>
                        <a href="/hotel_ajax/public/servicio.php" class="py-4 px-2 text-white font-semibold hover-gradient transition duration-300"><i class="fas fa-concierge-bell pr-2"></i>Servicios</a>
                        <a href="/hotel_ajax/public/contact.php" class="py-4 px-2 text-white font-semibold hover-gradient transition duration-300"><i class="fas fa-envelope pr-2"></i>Contacto</a>
                    </div>
                </div>
                <!-- Secondary Navbar items -->
                <div class="hidden md:flex items-center space-x-3" id="auth-links">
                    <a href="/hotel_ajax/sesion/login.php" class="py-4 px-2 text-white font-semibold hover-gradient transition duration-300"><i class="fas fa-sign-in-alt pr-2"></i>Iniciar Sesión</a>
                    <a href="/hotel_ajax/sesion/register.php" class="py-4 px-2 text-white font-semibold hover-gradient transition duration-300"><i the="fas fa-user-plus pr-2"></i>Registrarse</a>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="outline-none mobile-menu-button">
                        <svg class="w-6 h-6 text-white hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- mobile menu -->
        <div class="hidden mobile-menu">
            <ul>
                <li><a href="/hotel_ajax/public/home.php" class="block text-sm px-2 py-4 hover:bg-gray-700 text-white transition duration-300"><i class="fas fa-home pr-2"></i>Inicio</a></li>
                <li><a href="/hotel_ajax/public/habitacion.php" class="block text-sm px-2 py-4 hover:bg-gray-700 text-white transition duration-300"><i class="fas fa-bed pr-2"></i>Habitaciones</a></li>
                <li><a href="/hotel_ajax/public/reserva.php" class="block text-sm px-2 py-4 hover:bg-gray-700 text-white transition duration-300"><i class="fas fa-calendar-alt pr-2"></i>Reservar</a></li>
                <li><a href="/hotel_ajax/public/servcio.php" the="block text-sm px-2 py-4 hover:bg-gray-700 text-white transition duration-300"><i class="fas fa-concierge-bell pr-2"></i>Servicios</a></li>
                <li><a href="/hotel_ajax/public/contact.php" class="block text-sm px-2 py-4 hover:bg-gray-700 text-white transition duration-300"><i class="fas fa-envelope pr-2"></i>Contacto</a></li>
                <li><a href="/hotel_ajax/sesion/login.php" class="block text-sm px-2 py-4 hover:bg-gray-700 text-white transition duration-300"><i class="fas fa-sign-in-alt pr-2"></i>Iniciar Sesión</a></li>
                <li><a href="/hotel_ajax/sesion/register.php" class="block text-sm px-2 py-4 hover:bg-gray-700 text-white transition duration-300"><i class="fas fa-user-plus pr-2"></i>Registrarse</a></li>
            </ul>
        </div>
    </nav>
    <script>
        $(document).ready(function() {
            var nombre = localStorage.getItem('nombre');
            var apellido = localStorage.getItem('apellido');
            if (nombre) {
                $('#auth-links').html('<span class="py-4 px-2 text-white font-semibold">Hola, ' + nombre + ' ' + apellido + '</span><a href="#" onclick="logout()" class="py-4 px-2 text-white font-semibold hover-gradient transition duration-300"><i class="fas fa-sign-out-alt pr-2"></i>Cerrar Sesión</a>');
            }
        });

        function logout() {
            localStorage.clear();
            window.location.href = '/hotel_ajax/sesion/login.php';
        }

        const btn = document.querySelector(".mobile-menu-button");
        const menu = document.querySelector(".mobile-menu");

        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });
    </script>
    
</body>
</html>
