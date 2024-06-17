<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Estufa - PI3</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Link para o CSS customizado -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-dark text-white">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ route('index') }}">
            <i class="fas fa-seedling"></i> Controle de Estufa
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                @if (Auth::check())
                    <li class="nav-item" id="cab">
                        <a class="nav-link" href="{{ route('admin.index') }}">PAINEL ADMIN</a>
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
        <h1 class="text-center">Bem-vindo ao Controle de Estufa</h1>
        <p class="text-center">Gerencie sua estufa de forma eficiente e inteligente.</p>

        <div class="container p-3 text-center">
            <h2>Últimos Dados dos Sensores</h2>
            <div id="sensorData" class="d-flex flex-wrap justify-content-center mt-5">
                <div class="col-md-4 mt-4"><i class="fa-solid"></i> <b>Temperatura:</b> <span id="tempValue">--</span> °C</div>
                <div class="col-md-4 mt-4"><i class="fa-solid"></i><b>Umidade:</b> <span id="humidityValue">--</span> %</div>
                <div class="col-md-4 mt-4"><i class="fa-solid"></i><b>Umidade do Solo:</b> <span id="soilMoistureValue">--</span> %</div>
                <div class="col-md-4 mt-4"><i class="fa-solid"></i> <b>Níveis de CO2:</b> <span id="co2Value">--</span> ppm</div>
                <div class="col-md-4 mt-4"><i class="fa-solid"></i><b>Luz:</b> <span id="lightValue">--</span> lux</div>
                <div class="col-md-4 mt-4"><i class="fa-solid"></i><b>pH do Solo:</b> <span id="phValue">--</span></div>
            </div>
        </div>
        
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-secondary text-white">
                        <div class="card-header">Gráfico de Temperatura e Umidade(Média Por Tempo)</div>
                        <div class="card-body">
                            <canvas id="tempHumChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-secondary text-white">
                        <div class="card-header">Gráfico de Níveis de CO2 e Luz(Média Por Tempo)</div>
                        <div class="card-body">
                            <canvas id="co2LightChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-secondary text-white pt-1 pb-1 mt-4">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-12">
                    <p>Desenvolvido para auxiliar no controle de estufas</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function fetchData() {
            axios.get('http://127.0.0.1:5000/api/sensors')
                .then(response => {
                    console.log('API response:', response);  // Log da resposta da API
                    const data = response.data;
                    if (data) {
                        document.getElementById('tempValue').textContent = data.temperature;
                        document.getElementById('humidityValue').textContent = data.humidity;
                        document.getElementById('soilMoistureValue').textContent = data.soil_moisture;
                        document.getElementById('co2Value').textContent = data.co2_levels;
                        document.getElementById('lightValue').textContent = data.light_intensity;
                        document.getElementById('phValue').textContent = data.soil_ph;

                        updateCharts(data); // Atualizar gráficos com os novos dados
                    } else {
                        console.error('Dados da API estão vazios ou indefinidos:', data);
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar dados da API:', error);
                });
        }

        function updateCharts(data) {
            const time = new Date().toLocaleTimeString();
            tempHumChart.data.labels.push(time);
            tempHumChart.data.datasets[0].data.push(data.temperature);
            tempHumChart.data.datasets[1].data.push(data.humidity);

            co2LightChart.data.labels.push(time);
            co2LightChart.data.datasets[0].data.push(data.co2_levels);
            co2LightChart.data.datasets[1].data.push(data.light_intensity);

            tempHumChart.update();
            co2LightChart.update();
        }

        let tempHumChart;
        let co2LightChart;

        document.addEventListener('DOMContentLoaded', function() {
            fetchData(); // Carregar dados ao iniciar
            setInterval(fetchData, 5000); // Atualizar dados a cada 1 segundo

            const ctxTempHum = document.getElementById('tempHumChart').getContext('2d');
            tempHumChart = new Chart(ctxTempHum, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [
                        {
                            label: 'Temperature',
                            data: [],
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: false,
                        },
                        {
                            label: 'Humidity',
                            data: [],
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: false,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Time',
                                color: '#FFFFFF'
                            },
                            ticks: {
                                color: '#FFFFFF'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Value',
                                color: '#FFFFFF'
                            },
                            ticks: {
                                color: '#FFFFFF'
                            }
                        }
                    }
                }
            });


            const ctxCo2Light = document.getElementById('co2LightChart').getContext('2d');
            co2LightChart = new Chart(ctxCo2Light, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [
                        {
                            label: 'CO2 Levels',
                            data: [],
                            borderColor: 'rgba(153, 102, 255, 1)',
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            fill: false,
                        },
                        {
                            label: 'Light Intensity',
                            data: [],
                            borderColor: 'rgba(255, 159, 64, 1)',
                            backgroundColor: 'rgba(255, 159, 64, 0.2)',
                            fill: false,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Time',
                                color: '#FFFFFF'
                            },
                            ticks: {
                                color: '#FFFFFF'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Value',
                                color: '#FFFFFF'
                            },
                            ticks: {
                                color: '#FFFFFF'
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>