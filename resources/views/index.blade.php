<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Estufa - PI3</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-dark text-white">
    <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background-color: #212529;"> -->
    <nav class="navbar navbar-expand-lg nav" style="background-color: #212529;">
        <p class="navbar-brand nav1">
            <i class="fas fa-seedling"></i> Controle de Estufa
        </p>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">

                @if (Auth::check())
                    <li class="nav-item" id="cab">
                        <a class="nav-link" href="{{ route('adm') }}">PAINEL ADMIN</a>
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
                <div class="col-md-4"><i class="fa-solid"></i> <b>Temperatura:</b> <span id="tempValue">--</span> °C</div>
                <div class="col-md-4"><i class="fa-solid"></i><b>Umidade:</b> <span id="humidityValue">--</span> %</div>
                <div class="col-md-4"><i class="fa-solid"></i><b>Umidade do Solo:</b> <span id="soilMoistureValue">--</span> %</div>
                <div class="col-md-4 mt-4"><i class="fa-solid"></i> <b>Níveis de CO2:</b> <span id="co2Value">--</span> ppm</div>
                <div class="col-md-4 mt-4"><i class="fa-solid"></i><b>Luz:</b> <span id="lightValue">--</span> lux</div>
                <div class="col-md-4 mt-4"><i class="fa-solid"></i><b>pH do Solo:</b> <span id="phValue">--</span></div>
            </div>
        </div>
    </div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

    <footer class="bg-gray-800 text-white pt-4 pb-4 mt-4" style="background-color: #212529";>
        <div class="container text-center">
            <div class="flex flex-col items-center">
                <div class="mb-4">
                    <img src="https://via.placeholder.com/150" alt="Logo Estufa" class="w-24 h-24">
                </div>
                <div>
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
                    } else {
                        console.error('Dados da API estão vazios ou indefinidos:', data);
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar dados da API:', error);
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetchData(); // Carregar dados ao iniciar
            setInterval(fetchData, 1000); // Atualizar dados a cada 1 segundo
        });
    </script>
</body>
</html>
