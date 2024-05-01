<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios del Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body class="bg-gray-100">
    <?php include_once '../template_cliente/header.php'; ?>
    
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-4xl font-bold text-center mb-6">Nuestros Servicios</h2>
        <div id="services-container" class="flex flex-wrap justify-center">
            <!-- Los servicios se cargarán aquí dinámicamente -->
            <p class="text-center w-full text-gray-600">Cargando servicios...</p>
        </div>
    </div>
    
    <?php include_once '../template_cliente/footer.php'; ?>
    <script src="/hotel_ajax/js/servicio.js"></script>
</body>
</html>
