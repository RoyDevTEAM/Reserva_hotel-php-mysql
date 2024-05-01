document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('graficoDinamico');
    const tituloGrafico = document.getElementById('tituloGrafico');
    const selectorGrafico = document.getElementById('tipoReporte');

    function cargarYDibujarGrafico() {
        const tipo = selectorGrafico.value;
        const url = `../../functions/reportesCongraficos.php?tipo=${tipo}`;

        fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error de datos:', data.error);
                return;
            }
            tituloGrafico.textContent = selectorGrafico.options[selectorGrafico.selectedIndex].text;
            if (window.graficoActual) {
                window.graficoActual.destroy();
            }
            window.graficoActual = dibujarGrafico(canvas.getContext('2d'), tipo, data.data);
        })
        .catch(error => console.error('Error al cargar los datos:', error));
    }

    selectorGrafico.addEventListener('change', cargarYDibujarGrafico);
    cargarYDibujarGrafico();  // Carga inicial
});

function dibujarGrafico(ctx, tipo, data) {
    const config = {
        type: 'bar', // Default type
        data: {
            labels: data.map(item => item.label),
            datasets: [{
                label: `${tipo[0].toUpperCase() + tipo.slice(1)} Data`,
                data: data.map(item => item.value),
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } },
            plugins: { legend: { display: true } }
        }
    };

    switch (tipo) {
        case 'servicios':
            config.type = 'pie';
            config.options.plugins.legend.position = 'top';
            break;
        case 'metodosPago':
            config.type = 'doughnut';
            config.options.plugins.legend.position = 'bottom';
            break;
    }

    return new Chart(ctx, config);
}
