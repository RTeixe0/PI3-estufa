<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Controle de Estufa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</head>
<body class="bg-dark text-white">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <i class="fas fa-seedling"></i> Controle de Estufa
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                @if (Auth::check())
                    <li class="nav-item" id="cab">
                        <a class="nav-link" href="{{ route('adm') }}">VOLTAR</a>
                    </li>
                    <li class="nav-item" id="cab">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            LOGOUT
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @else
                    <li class="nav-item" id="cab">
                        <a class="nav-link" href="{{ route('login') }}">LOGIN</a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">LOG - GERAL</h1>

        <div class="row">
            <div class="col-md-12">
                <input type="date" id="searchInput" class="form-control" placeholder="Pesquisar no log...">
            </div>
        </div>

        <!-- Tabela para exibir os dados dos sensores -->
        <div class="table-responsive mt-4">
            <table class="table table-dark table-bordered">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Temperatura</th>
                        <th>Umidade</th>
                        <th>Soil Moisture</th>
                        <th>Niveis CO2</th>
                        <th>Instensidade da Luz</th>
                        <th>PH</th>
                    </tr>
                </thead>
                <tbody id="sensorTableBody">
                    <!-- Os dados serão inseridos aqui pelo JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Controles de paginação -->
        <div class="d-flex justify-content-between mt-2">
            <button class="btn btn-primary" id="prevPage">Página Anterior</button>
            <span id="pageIndicator"></span>
            <button class="btn btn-primary" id="nextPage">Próxima Página</button>
        </div>

        <!-- Gráficos -->
        <div class="row" id="chartsContainer" style="display: none;">
            <div class="col-md-6">
                <canvas id="temperatureChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="humidityChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="soilMoistureChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="co2LevelsChart"></canvas>
            </div>
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
            let currentPage = 1;
            const pageSize = 100;
            let allData = [];

            // Função para buscar dados dos sensores do servidor
            async function fetchSensorData() {
                try {
                    const response = await fetch('http://localhost:5000/api/sensors');
                    const data = await response.json();
                    console.log('Dados dos sensores:', data);
                    allData = data;
                    displayTableData();
                    displayCharts(allData);
                } catch (error) {
                    console.error('Erro ao buscar dados dos sensores:', error);
                }
            }

            // Função para exibir os dados na tabela
            function displayTableData() {
                const tableBody = document.getElementById('sensorTableBody');
                tableBody.innerHTML = '';

                const start = (currentPage - 1) * pageSize;
                const end = start + pageSize;
                const pageData = allData.slice(start, end);

                pageData.forEach(sensor => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${new Date(sensor.timestamp).toLocaleString('pt-BR', { timeZone: 'UTC' })}</td>
                        <td>${sensor.temperature}</td>
                        <td>${sensor.humidity}</td>
                        <td>${sensor.soil_moisture}</td>
                        <td>${sensor.co2_levels}</td>
                        <td>${sensor.light_intensity}</td>
                        <td>${sensor.soil_ph}</td>
                    `;
                    tableBody.appendChild(row);
                });

                document.getElementById('pageIndicator').innerText = `Página ${currentPage}`;
            }

            // Inicializar a primeira carga de dados
            await fetchSensorData();

            // Adicionar event listeners aos botões de paginação
            document.getElementById('prevPage').addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    displayTableData();
                }
            });

            document.getElementById('nextPage').addEventListener('click', function() {
                if ((currentPage * pageSize) < allData.length) {
                    currentPage++;
                    displayTableData();
                }
            });

            // Função para preparar dados dos gráficos
            function prepareData(data) {
                return {
                    temperatureData: data.map(sensor => ({ x: new Date(sensor.timestamp), y: sensor.temperature })),
                    humidityData: data.map(sensor => ({ x: new Date(sensor.timestamp), y: sensor.humidity })),
                    soilMoistureData: data.map(sensor => ({ x: new Date(sensor.timestamp), y: sensor.soil_moisture })),
                    co2LevelsData: data.map(sensor => ({ x: new Date(sensor.timestamp), y: sensor.co2_levels })),
                    lightIntensityData: data.map(sensor => ({ x: new Date(sensor.timestamp), y: sensor.light_intensity })),
                    soilPhData: data.map(sensor => ({ x: new Date(sensor.timestamp), y: sensor.soil_ph }))
                };
            }

            // Função para criar gráfico
            function createChart(context, label, data, color) {
                return new Chart(context, {
                    type: 'line',
                    data: {
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
                                type: 'time',
                                time: {
                                    unit: 'day',
                                    displayFormats: {
                                        day: 'MMM D'
                                    },
                                    tooltipFormat: 'll HH:mm'
                                },
                                ticks: {
                                    color: 'white' // Define a cor dos ticks do eixo X para branco
                                }
                            },
                            y: {
                                ticks: {
                                    color: 'white' // Define a cor dos ticks do eixo Y para branco
                                }
                            }
                        }
                    }
                });
            }

            // Função para exibir gráficos
            function displayCharts(data) {
                const { temperatureData, humidityData, soilMoistureData, co2LevelsData, lightIntensityData, soilPhData } = prepareData(data);

                createChart(document.getElementById('temperatureChart').getContext('2d'), 'Temperature', temperatureData, 'rgba(255, 99, 132, 1)');
                createChart(document.getElementById('humidityChart').getContext('2d'), 'Humidity', humidityData, 'rgba(54, 162, 235, 1)');
                createChart(document.getElementById('soilMoistureChart').getContext('2d'), 'Soil Moisture', soilMoistureData, 'rgba(75, 192, 192, 1)');
                createChart(document.getElementById('co2LevelsChart').getContext('2d'), 'CO2 Levels', co2LevelsData, 'rgba(153, 102, 255, 1)');
                createChart(document.getElementById('lightIntensityChart').getContext('2d'), 'Light Intensity', lightIntensityData, 'rgba(255, 159, 64, 1)');
                createChart(document.getElementById('soilPhChart').getContext('2d'), 'Soil pH', soilPhData, 'rgba(255, 206, 86, 1)');
            }

            // Adicionar event listener ao campo de pesquisa
            document.getElementById('searchInput').addEventListener('change', function(event) {
                const query = event.target.value;
                const filteredData = allData.filter(sensor => {
                    const sensorDate = new Date(sensor.timestamp);
                    const formattedDate = sensorDate.toISOString().split('T')[0];
                    return formattedDate === query;
                });
                currentPage = 1; // Resetar para a primeira página ao filtrar
                allData = filteredData;
                displayTableData();

                // Exibir gráficos apenas se houver dados filtrados
                if (filteredData.length > 0) {
                    document.getElementById('chartsContainer').style.display = 'block';
                    displayCharts(filteredData);
                } else {
                    document.getElementById('chartsContainer').style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
