<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard del Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body class="bg-gray-100">
    <?php include_once '../template/header.php'; ?>
 
    <div class="container mx-auto px-4 py-4">
        <h1 class="text-4xl font-bold text-center mb-6">Dashboard del Empleado</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-white mb-8">
            <div class="bg-blue-500 p-4 shadow rounded-lg">
                <div>
                    <h2 class="text-lg font-semibold">Reservas este Mes</h2>
                    <p id="monthlyReservations" class="text-3xl">0</p>
                </div>
            </div>
            <div class="bg-green-500 p-4 shadow rounded-lg">
                <div>
                    <h2 class="text-lg font-semibold">Ingresos del Mes</h2>
                    <p id="totalRevenueThisMonth" class="text-3xl">$0</p>
                </div>
            </div>
            <div class="bg-purple-500 p-4 shadow rounded-lg">
                <div>
                    <h2 class="text-lg font-semibold">Cliente Más Frecuente</h2>
                    <p id="mostFrequentClient" class="text-xl">N/A</p>
                </div>
            </div>
            <div class="bg-red-500 p-4 shadow rounded-lg">
                <div>
                    <h2 class="text-lg font-semibold">Ingresos Totales</h2>
                    <p id="totalRevenueOverall" class="text-3xl">$0</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="bg-white p-4 shadow rounded-lg">
                <h2 class="text-xl font-bold mb-4">Reservas en los Últimos 5 Meses</h2>
                <canvas id="reservationsChart"></canvas>
            </div>
            <div class="bg-white p-4 shadow rounded-lg">
                <h2 class="text-xl font-bold mb-4">Tipos de Habitación Más Reservados</h2>
                <canvas id="roomsChart"></canvas>
            </div>
            <div class="bg-white p-4 shadow rounded-lg">
                <h2 class="text-xl font-bold mb-4">Métodos de Pago Más Utilizados</h2>
                <canvas id="paymentMethodsChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            fetch('../functions/dashboard.php')
                .then(response => response.json())
                .then(data => {
                    $('#monthlyReservations').text(data.monthlyReservations);
                    $('#totalRevenueThisMonth').text(`$${parseFloat(data.totalRevenueThisMonth).toFixed(2)}`);
                    $('#mostFrequentClient').text(data.mostFrequentClient);
                    $('#totalRevenueOverall').text(`$${parseFloat(data.totalRevenueOverall).toFixed(2)}`);

                    initChart('reservationsChart', 'bar', data.reservationsLastFiveMonths.map(x => x.month), data.reservationsLastFiveMonths.map(x => x.count), 'Reservas por Mes', ["#4dc9f6","#f67019","#f53794","#537bc4","#acc236","#166a8f"]);
                    initChart('roomsChart', 'doughnut', data.mostBookedRooms.map(x => x.tipo_habitacion), data.mostBookedRooms.map(x => x.count), 'Habitaciones Reservadas', ["#7d4f50","#58595b","#519839","#f1e8ca","#e2a829"]);
                    initChart('paymentMethodsChart', 'pie', data.mostUsedPaymentMethods.map(x => x.metodo_pago), data.mostUsedPaymentMethods.map(x => x.count), 'Métodos de Pago', ["#4D5360","#949FB1","#D4CCC5","#E2EAE9","#F7464A"]);
                })
                .catch(error => console.error('Error loading dashboard data:', error));
        });

        function initChart(chartId, type, labels, data, label, backgroundColor) {
            var ctx = document.getElementById(chartId).getContext('2d');
            new Chart(ctx, {
                type: type,
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: backgroundColor,
                        borderColor: backgroundColor.map(color => color.replace('0.2', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: type === 'bar' ? { y: { beginAtZero: true } } : {},
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>
