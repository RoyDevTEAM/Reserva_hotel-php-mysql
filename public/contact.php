<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-gray-100">
<?php include_once '../template_cliente/header.php'; ?>

    <div class="container mx-auto px-4 py-10">
        <h1 class="text-4xl font-bold text-center mb-12 text-blue-600">Contacto</h1>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <form action="#" method="POST" class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" id="name" name="name" required class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                            <input type="email" id="email" name="email" required class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Mensaje</label>
                            <textarea id="message" name="message" rows="4" required class="mt-1 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-300 ease-in-out">Enviar Mensaje <i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div>
                <h2 class="text-2xl font-bold mb-4">Testimonios</h2>
                <div class="space-y-4">
                    <p class="bg-white p-4 rounded-lg shadow text-gray-600 italic">"Excelente servicio y atención al cliente. ¡Recomendado!"</p>
                    <p class="bg-white p-4 rounded-lg shadow text-gray-600 italic">"Una experiencia inolvidable, todo fue perfecto desde el inicio hasta el fin."</p>
                    <p class="bg-white p-4 rounded-lg shadow text-gray-600 italic">"Muy satisfecho con la rapidez y eficacia del personal. ¡Gracias!"</p>
                </div>
            </div>
        </div>
    </div>
    <?php include_once '../template_cliente/footer.php'; ?>

</body>
</html>
