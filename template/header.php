<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- Incluir DataTables CSS y JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <!-- Incluir Buttons extension para DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
        /* Menú desplegable para el móvil */
        .mobile-menu li {
            background: #1a202c; /* Color de fondo más claro para los items del menú */
            border-bottom: 1px solid rgba(255, 255, 255, 0.1); /* Borde para separar items */
        }

        /* Estilos adicionales para el dropdown */
        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu li:hover {
            background-color: #2d3748; /* Fondo más oscuro para el hover */
        }
    </style>
    <script>
      // Función para manejar el menú desplegable
document.addEventListener("DOMContentLoaded", function(){
    // Selector de todos los menús con submenús
    document.querySelectorAll('.dropdown').forEach(function(menuItem) {
        let toggleLink = menuItem.querySelector('a');
        toggleLink.addEventListener('click', function(event) {
            let submenu = menuItem.querySelector('.dropdown-menu');
            if (submenu) {
                if (submenu.style.display === 'block') {
                    submenu.style.display = 'none';
                } else {
                    submenu.style.display = 'block';
                }
                event.preventDefault(); // Previene el comportamiento del enlace solo cuando hay un submenú
            }
        });
    });

    // Script para manejar la apertura del menú móvil
    const btn = document.querySelector("button.mobile-menu-button");
    const menu = document.querySelector(".mobile-menu");

    btn.addEventListener("click", () => {
        menu.classList.toggle("hidden");
    });
});

    </script>
</head>
<body class="bg-gray-100" onload="showUserGreeting()">
    <nav class="bg-gray-800 shadow-lg" >
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                <div>
    <!-- Website Logo -->
    <a href="#" class="flex items-center py-4 px-2">
        <!-- Reemplazar el ícono con una imagen -->
        <img src="https://www.macororo.com/wp-content/uploads/2022/05/Macororo-15-logo-Blanco-sombra.png" alt="Logo" class="h-8"> <!-- Controle el tamaño con las clases de Tailwind -->
        <span class="font-semibold text-white text-lg ml-2">Hotel</span>
    </a>
</div>

                    <!-- Primary Navbar items -->
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="/hotel_ajax/empleado/dashboard.php" class="py-4 px-2 text-white font-semibold hover:bg-gray-700 transition duration-300">Dashboard <i class="fas fa-tachometer-alt"></i></a>
                        <a href="/hotel_ajax/empleado/gestion_reserva/index.php" class="py-4 px-2 text-white font-semibold hover:bg-gray-700 transition duration-300">Reservas <i class="fas fa-book"></i></a>

                        <a href="/hotel_ajax/empleado/gestion_cliente/index.php" class="py-4 px-2 text-white font-semibold hover:bg-gray-700 transition duration-300">Clientes <i class="fas fa-users"></i></a>
                        <a href="/hotel_ajax/empleado/gestion_habitacion/index.php" class="py-4 px-2 text-white font-semibold hover:bg-gray-700 transition duration-300">Habitaciones <i class="fas fa-bed"></i></a>
                        <a href="/hotel_ajax/empleado/gestion_usuario/index.php" class="py-4 px-2 text-white font-semibold hover:bg-gray-700 transition duration-300">Usuarios <i class="fas fa-user-cog"></i></a>
                        <div class="dropdown relative py-4 px-2">
    <a href="#" class="text-white font-semibold hover:bg-gray-700 transition duration-300">Reportes <i class="fas fa-chart-bar pr-2"></i><i class="fas fa-chevron-down"></i></a>
    <div class="dropdown-menu absolute hidden h-auto flex flex-col bg-gray-700 text-white">
        <a href="/hotel_ajax/empleado/reporte/cliente.php" class="py-2 px-4 hover:bg-gray-600">Clientes <i class="fas fa-user-tie"></i></a>
        <a href="/hotel_ajax/empleado/reporte/pago.php" class="py-2 px-4 hover:bg-gray-600">Pagos <i class="fas fa-hand-holding-usd"></i></a>
        <a href="/hotel_ajax/empleado/reporte/reserva.php" class="py-2 px-4 hover:bg-gray-600">Reservas <i class="fas fa-calendar-check"></i></a>
    </div>
</div>

                    </div>
                </div>
                <!-- Secondary Navbar items -->
                <div class="hidden md:flex items-center space-x-3 ">
                    <button id="logoutButton" class="py-4 px-2 text-white font-semibold hover:bg-gray-700 transition duration-300">
                        <span id="userGreeting"></span> Cerrar Sesión <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="outline-none mobile-menu-button">
                        <svg class=" w-6 h-6 text-white hover:text-green-500 " 
                            x-show="!showMenu" 
                            fill="none" 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            stroke-width="2" 
                            viewBox="0 0 24 24" 
                            stroke="currentColor">
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- mobile menu -->
        <div class="hidden mobile-menu">
            <ul class="">
                <li class="active"><a href="/hotel_ajax/empleado/dashboard.php" class="block text-sm px-2 py-4 text-white bg-gray-700 font-semibold">Dashboard</a></li>
                
                <li><a href="/hotel_ajax/empleado/gestion_habitacion/index.php" class="block text-sm px-2 py-4 hover:bg-gray-700 transition duration-300">Habitaciones</a></li>
<li><a href="/hotel_ajax/empleado/gestion_cliente/index.php" class="block text-sm px-2 py-4 hover:bg-gray-700 transition duration-300">Clientes</a></li>
                <li><a href="/hotel_ajax/empleado/gestion_reserva/index.php" class="block text-sm px-2 py-4 hover:bg-gray-700 transition duration-300">Reservas</a></li>
                <li><a href="/hotel_ajax/empleado/gestion_usuario/index.php" class="block text-sm px-2 py-4 hover:bg-gray-700 transition duration-300">Usuarios</a></li>
                <!-- Dropdown menu -->
                <li class="dropdown">
                    <a href="#" class="block text-sm px-2 py-4 hover:bg-gray-700 transition duration-300">Reportes</a>
                    <ul class="dropdown-menu mobile-submenu hidden">
                        <li><a href="/hotel_ajax/empleado/reporte/cliente.php" class="block text-sm px-2 py-4 hover:bg-gray-600">Clientes</a></li>
                        <li><a href="/hotel_ajax/empleado/reporte/pago.php" class="block text-sm px-2 py-4 hover:bg-gray-600">Pagos</a></li>
                        <li><a href="/hotel_ajax/empleado/reporte/reserva.php" class="block text-sm px-2 py-4 hover:bg-gray-600">Res</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>    
    <script>
        function showUserGreeting() {
            const nombre = localStorage.getItem('nombre');
            const apellido = localStorage.getItem('apellido');
            if (nombre && apellido) {
                document.getElementById('userGreeting').textContent = 'Hola, ' + nombre;
            }
        }
    </script>
    <script>
        // Script para manejar la apertura del menú móvil
        const btn = document.querySelector("button.mobile-menu-button");
        const menu = document.querySelector(".mobile-menu");

        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });
    </script>
    <script src="../../js/login.js"></script>
</body>
</html>
