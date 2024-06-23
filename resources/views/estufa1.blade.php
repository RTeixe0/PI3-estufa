<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Controle de Estufa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Link para o CSS customizado -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/stock.js"></script>
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
                    <a class="nav-link" href="{{route('adm')}}">VOLTAR</a>
                </li>
                <li class="nav-item" id="cab">
                    <a class="nav-link" href="{{ route('logout') }}">LOGOUT</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center text-success">Painel Administrativo - Controle de Estufa</h1>

        <!-- Menu de seleção de gráficos -->
        <div class="form-group">
            <label for="chartSelect">Selecione o gráfico para visualizar:</label>
            <select class="form-control" id="chartSelect">
                <option value="temperatureChart">Temperatura</option>
                <option value="humidityChart">Umidade</option>
                <option value="soilMoistureChart">Umidade do Solo</option>
                <option value="co2LevelsChart">Níveis CO2</option>
                <option value="lightIntensityChart">Intensidade da Luz</option>
                <option value="soilPhChart">pH do solo</option>
            </select>
        </div>

        <!-- Container para os gráficos -->
        <div id="chartContainer" class="mt-4" style="min-height: 400px;"></div>
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

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            let sensorData = [];
            let temperatureData = [], humidityData = [], soilMoistureData = [], co2LevelsData = [], lightIntensityData = [], soilPhData = [];
            let currentChart = null;

            // Função para buscar dados dos sensores do servidor
            async function fetchSensorData() {
                const response = await fetch('http://localhost:5000/api/sensors');
                const data = await response.json();
                console.log(data); // Adicione esta linha para verificar os dados
                return data;
            }

            // Função para preparar dados dos gráficos
            function prepareData() {
                temperatureData = aggregateData(sensorData.map(sensor => [new Date(sensor.timestamp).getTime(), sensor.temperature]));
                humidityData = aggregateData(sensorData.map(sensor => [new Date(sensor.timestamp).getTime(), sensor.humidity]));
                soilMoistureData = aggregateData(sensorData.map(sensor => [new Date(sensor.timestamp).getTime(), sensor.soil_moisture]));
                co2LevelsData = aggregateData(sensorData.map(sensor => [new Date(sensor.timestamp).getTime(), sensor.co2_levels]));
                lightIntensityData = aggregateData(sensorData.map(sensor => [new Date(sensor.timestamp).getTime(), sensor.light_intensity]));
                soilPhData = aggregateData(sensorData.map(sensor => [new Date(sensor.timestamp).getTime(), sensor.soil_ph]));
            }

            // Função para agregar dados para reduzir a quantidade de pontos no gráfico
            function aggregateData(data, points = 100) {
                if (data.length <= points) return data;
                const factor = Math.ceil(data.length / points);
                return data.filter((_, index) => index % factor === 0);
            }

            // Função para criar gráfico de linha
            function createLineChart(container, title, data, color) {
                if (currentChart) {
                    currentChart.destroy();
                }

                currentChart = Highcharts.chart(container, {
                    chart: {
                        type: 'line',
                        backgroundColor: '#2b2b2b'
                    },
                    title: {
                        text: title,
                        style: {
                            color: '#FFFFFF'
                        }
                    },
                    series: [{
                        name: title,
                        data: data,
                        color: color
                    }],
                    xAxis: {
                        labels: {
                            style: {
                                color: '#FFFFFF'
                            },
                            formatter: function() {
                                const date = new Date(this.value);
                                const options = { timeZone: 'America/Sao_Paulo', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                                return new Intl.DateTimeFormat('pt-BR', options).format(date);
                            }
                        }
                    },
                    yAxis: {
                        labels: {
                            style: {
                                color: '#FFFFFF'
                            }
                        }
                    }
                });
            }

            // Função para exibir o gráfico selecionado
            function displaySelectedChart(chartId) {
                let data, title, color;

                switch(chartId) {
                    case 'temperatureChart':
                        data = temperatureData;
                        title = 'Temperature';
                        color = 'rgba(255, 99, 132, 1)';
                        break;
                    case 'humidityChart':
                        data = humidityData;
                        title = 'Humidity';
                        color = 'rgba(54, 162, 235, 1)';
                        break;
                    case 'soilMoistureChart':
                        data = soilMoistureData;
                        title = 'Soil Moisture';
                        color = 'rgba(75, 192, 192, 1)';
                        break;
                    case 'co2LevelsChart':
                        data = co2LevelsData;
                        title = 'CO2 Levels';
                        color = 'rgba(153, 102, 255, 1)';
                        break;
                    case 'lightIntensityChart':
                        data = lightIntensityData;
                        title = 'Light Intensity';
                        color = 'rgba(255, 159, 64, 1)';
                        break;
                    case 'soilPhChart':
                        data = soilPhData;
                        title = 'Soil pH';
                        color = 'rgba(255, 206, 86, 1)';
                        break;
                    default:
                        return;
                }

                document.getElementById('chartContainer').innerHTML = ''; // Limpar o container
                const chartDiv = document.createElement('div');
                chartDiv.id = chartId;
                document.getElementById('chartContainer').appendChild(chartDiv);

                createLineChart(chartId, title, data, color);
            }

            // Carregar dados dos sensores e preparar dados para os gráficos
            sensorData = await fetchSensorData();
            prepareData();

            // Adicionar event listener ao menu de seleção
            document.getElementById('chartSelect').addEventListener('change', function() {
                const selectedChartId = this.value;
                displaySelectedChart(selectedChartId);
            });

            // Exibir o primeiro gráfico por padrão
            displaySelectedChart('temperatureChart');
        });
    </script>
</body>
</html>
