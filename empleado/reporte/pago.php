<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes Dinámicos</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body class="bg-gray-100">
<?php include_once '../../template/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-center mb-8 text-gray-800">Reportes Dinámicos</h1>

    <div class="max-w-lg mx-auto bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5">
            <div class="mb-4">
                <label for="tipoReporte" class="block text-sm font-medium text-gray-700">Seleccione el tipo de reporte:</label>
                <select id="tipoReporte" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="ocupacion">Ocupación de Habitaciones</option>
                    <option value="ingresos">Ingresos por Habitaciones</option>
                    <option value="servicios">Servicios Más Populares</option>
                    <option value="metodosPago">Efectividad de Métodos de Pago</option>
                </select>
            </div>
            <h2 id="tituloGrafico" class="text-lg font-semibold mb-4 text-gray-900">Ocupación de Habitaciones</h2>
            <div class="relative h-64">
                <canvas id="graficoDinamico"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="../../js/reportesCongraficos.js"></script>
</body>
</html>
