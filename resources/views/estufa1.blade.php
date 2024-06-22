<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Controle de Estufa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Link para o CSS customizado -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-dark text-white">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <i class="fas fa-seedling"></i> Controle de Estufa
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item" id="cab">
                    <a class="nav-link" href="{{route('index')}}">VOLTAR</a>
                </li>
                <li class="nav-item" id="cab">
                    <a class="nav-link" href="{{ route('logout') }}">LOGOUT</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Painel Administrativo - Controle de Estufa</h1>

        <!-- Gráficos -->
        <div class="row">
            <div class="col-md-6">
                <canvas id="temperatureChart"></canvas>
            </div>

            <div class="col-md-6">
                <canvas id="humidityChart"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <canvas id="soilMoistureChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="co2LevelsChart"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <canvas id="lightIntensityChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="soilPhChart"></canvas>
            </div>
        </div>
    </div>
    <br>
    <br>

    <footer class="bg-secondary text-white pt-1 pb-1 mt-4">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-12">
                    <p>Desenvolvido para auxiliar no controle de estufas</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            // Função para buscar dados dos sensores do servidor
            async function fetchSensorData() {
                const response = await fetch('http://localhost:5000/api/sensors');
                const data = await response.json();
                console.log(data); // Adicione esta linha para verificar os dados
                return data;
            }

            // Função para converter timestamp para data legível
            function convertTimestampToDate(timestamp) {
                return new Date(timestamp).toLocaleString('pt-BR', { timeZone: 'UTC' });
            }

            // Obter dados dos sensores
            const sensorData = await fetchSensorData();

            if (sensorData.length === 0) {
                console.error("No sensor data available.");
                return;
            }

            // Função para criar gráfico
            function createChart(context, label, data, color) {
                return new Chart(context, {
                    type: 'line',
                    data: {
                        labels: sensorData.map(sensor => convertTimestampToDate(sensor.timestamp)),
                        datasets: [{
                            label: label,
                            data: data,
                            backgroundColor: color,
                            borderColor: color,
                            fill: false,
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                labels: {
                                    color: 'white' // Define a cor das labels da legenda para branco
                                }
                            }
                        },
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Time',
                                    color: 'white' // Define a cor do título do eixo X para branco
                                },
                                ticks: {
                                    color: 'white' // Define a cor dos ticks do eixo X para branco
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: true,
                                    text: label,
                                    color: 'white' // Define a cor do título do eixo Y para branco
                                },
                                ticks: {
                                    color: 'white' // Define a cor dos ticks do eixo Y para branco
                                }
                            }
                        }
                    }
                });
            }

            // Preparar dados para os gráficos
            const temperatureData = sensorData.map(sensor => sensor.temperature);
            const humidityData = sensorData.map(sensor => sensor.humidity);
            const soilMoistureData = sensorData.map(sensor => sensor.soil_moisture);
            const co2LevelsData = sensorData.map(sensor => sensor.co2_levels);
            const lightIntensityData = sensorData.map(sensor => sensor.light_intensity);
            const soilPhData = sensorData.map(sensor => sensor.soil_ph);

            // Criar gráficos
            createChart(document.getElementById('temperatureChart').getContext('2d'), 'Temperature', temperatureData, 'rgba(255, 99, 132, 1)');
            createChart(document.getElementById('humidityChart').getContext('2d'), 'Humidity', humidityData, 'rgba(54, 162, 235, 1)');
            createChart(document.getElementById('soilMoistureChart').getContext('2d'), 'Soil Moisture', soilMoistureData, 'rgba(75, 192, 192, 1)');
            createChart(document.getElementById('co2LevelsChart').getContext('2d'), 'CO2 Levels', co2LevelsData, 'rgba(153, 102, 255, 1)');
            createChart(document.getElementById('lightIntensityChart').getContext('2d'), 'Light Intensity', lightIntensityData, 'rgba(255, 159, 64, 1)');
            createChart(document.getElementById('soilPhChart').getContext('2d'), 'Soil pH', soilPhData, 'rgba(255, 206, 86, 1)');
        });
    </script>
</body>
</html>
