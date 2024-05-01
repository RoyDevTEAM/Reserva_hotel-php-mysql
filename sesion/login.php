<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
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
        body, html {
            height: 100%;
            margin: 0;
        }
        .main-content {
            height: calc(100% - 60px); /* Adjust height by header's height */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
    </style>
</head>
<body class="bg-gray-800">
    <?php include_once '../template_cliente/header.php'; ?>

    <div class="main-content">
        <div class="bg-gray-900 p-8 rounded-lg shadow-lg max-w-sm w-full mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-100 mb-8">Iniciar Sesión</h2>
            <form id="loginForm" action="#" method="POST">
                <div class="mb-6">
                    <label for="username" class="block text-gray-300 text-sm font-bold mb-2">Nombre de Usuario</label>
                    <input type="text" id="username" name="username" required class="form-input w-full p-4 rounded-lg bg-gray-700 text-white focus:outline-none" placeholder="Tu nombre de usuario">
                </div>
                <div class="mb-8">
                    <label for="password" class="block text-gray-300 text-sm font-bold mb-2">Contraseña</label>
                    <input type="password" id="password" name="password" required class="form-input w-full p-4 rounded-lg bg-gray-700 text-white focus:outline-none" placeholder="••••••••••">
                </div>
                <button type="submit" class="form-button w-full p-4 rounded-lg text-white font-bold hover:bg-green-600 focus:outline-none">Acceder</button>
                <p class="text-center text-gray-300 text-sm mt-4">
                    ¿No tienes una cuenta? <a href="/hotel_ajax/sesion/register.php" class="text-blue-500 hover:text-blue-400">Regístrate aquí</a>
                </p>
            </form>
        </div>
    </div>
    <script src="/hotel_ajax/js/login.js"></script>
</body>
</html>
