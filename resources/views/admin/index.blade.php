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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> <!-- Adicione esta linha -->
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
                    @foreach ($sensors as $sensor)
                        <tr>
                            <td>{{ $sensor->timestamp }}</td>
                            <td>{{ $sensor->temperature }}</td>
                            <td>{{ $sensor->humidity }}</td>
                            <td>{{ $sensor->soil_moisture }}</td>
                            <td>{{ $sensor->co2_levels }}</td>
                            <td>{{ $sensor->light_intensity }}</td>
                            <td>{{ $sensor->soil_ph }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Extrair dados do PHP para JavaScript
            var sensorData = @json($sensors);

            // Função para converter timestamp para data legível
            function convertTimestampToDate(timestamp) {
                return moment(timestamp).format('YYYY-MM-DD HH:mm:ss');
            }

            // Atualizar tabela com datas legíveis
            var tableBody = document.getElementById('sensorTableBody');
            Array.from(tableBody.rows).forEach(function(row, index) {
                var timestampCell = row.cells[0];
                timestampCell.textContent = convertTimestampToDate(sensorData[index].timestamp);
            });

            // Função para criar gráfico
            function createChart(context, label, data, color) {
                return new Chart(context, {
                    type: 'line',
                    data: {
                        labels: data.map((_, index) => `Data ${index + 1}`),
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
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Time'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: true,
                                    text: label
                                }
                            }
                        }
                    }
                });
            }

            // Preparar dados para os gráficos
            var temperatureData = sensorData.map(sensor => sensor.temperature);
            var humidityData = sensorData.map(sensor => sensor.humidity);
            var soilMoistureData = sensorData.map(sensor => sensor.soil_moisture);
            var co2LevelsData = sensorData.map(sensor => sensor.co2_levels);
            var lightIntensityData = sensorData.map(sensor => sensor.light_intensity);
            var soilPhData = sensorData.map(sensor => sensor.soil_ph);

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
