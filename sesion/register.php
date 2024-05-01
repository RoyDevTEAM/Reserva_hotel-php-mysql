<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse en Hotel Admin Roy</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        .form-input, .form-button {
            transition: transform 250ms ease-in-out, box-shadow 250ms ease-in-out;
        }
        .form-input:hover, .form-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-button {
            background: linear-gradient(90deg, rgba(6,78,59,1) 0%, rgba(10,201,122,1) 100%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        .form-button:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.4);
        }
        body {
            background-color: #f7f7f7;
        }
    </style>
</head>
<body class="bg-gray-800">
    <?php include_once '../template_cliente/header.php'; ?>

    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-gray-900 p-8 rounded-lg shadow-lg max-w-lg w-full">
            <h2 class="text-3xl font-bold text-center text-gray-100 mb-8">Registrarse</h2>
            <form id="registerForm" action="#" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nombre" class="block text-gray-300 text-sm font-bold mb-2">Nombre</label>
                        <input type="text" id="nombre" name="nombre" required class="form-input w-full p-4 rounded-lg bg-gray-700 text-white focus:outline-none" placeholder="Tu nombre">
                    </div>
                    <div>
                        <label for="apellido" class="block text-gray-300 text-sm font-bold mb-2">Apellido</label>
                        <input type="text" id="apellido" name="apellido" required class="form-input w-full p-4 rounded-lg bg-gray-700 text-white focus:outline-none" placeholder="Tu apellido">
                    </div>
                    <div class="md:col-span-2">
                        <label for="email" class="block text-gray-300 text-sm font-bold mb-2">Email</label>
                        <input type="email" id="email" name="email" required class="form-input w-full p-4 rounded-lg bg-gray-700 text-white focus:outline-none" placeholder="ejemplo@correo.com">
                    </div>
                    <div>
                        <label for="password" class="block text-gray-300 text-sm font-bold mb-2">Contraseña</label>
                        <input type="password" id="password" name="password" required class="form-input w-full p-4 rounded-lg bg-gray-700 text-white focus:outline-none" placeholder="••••••••••">
                    </div>
                    <div>
                        <label for="telefono" class="block text-gray-300 text-sm font-bold mb-2">Teléfono</label>
                        <input type="text" id="telefono" name="telefono" class="form-input w-full p-4 rounded-lg bg-gray-700 text-white focus:outline-none" placeholder="Tu teléfono">
                    </div>
                    <div class="md:col-span-2">
                        <label for="direccion" class="block text-gray-300 text-sm font-bold mb-2">Dirección</label>
                        <input type="text" id="direccion" name="direccion" class="form-input w-full p-4 rounded-lg bg-gray-700 text-white focus:outline-none" placeholder="Tu dirección">
                    </div>
                </div>
                <button type="submit" class="form-button w-full p-4 rounded-lg text-white font-bold focus:outline-none">Registrar</button>
                <p class="text-center text-gray-300 text-sm mt-4">
                    ¿Ya tienes una cuenta? <a href="/hotel_ajax/sesion/login.php" class="text-blue-500 hover:text-blue-400">Inicia sesión</a>
                </p>
            </form>
        </div>
    </div>

    <script src="/hotel_ajax/js/register.js"></script> <!-- Asegúrate de que la ruta es correcta -->
</body>
</html>
