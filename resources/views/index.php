<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard da Estufa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <!-- <div class="container p-3">
        <h1>Dashboard da Estufa Inteligente</h1>
        <div id="sensorData" class="row">
             Os dados dos sensores serão carregados aqui 
        </div>
    </div> -->



    <div class="container p-3">
    <h1>Dashboard da Estufa Inteligente</h1>
    <div class="text-center mb-3">
        <button onclick="fetchData()" class="btn btn-primary">Atualizar Dados</button>
    </div>
    <div id="sensorData" class="d-flex flex-wrap justify-content-center">
        <div class="col-md-4"><i class="fa-solid fa-temperature-half"></i> <b>Temperatura:</b> <span id="tempValue">--</span> °C</div>
        <div class="col-md-4"><i class="fa-solid fa-droplet"></i> <b>Umidade:</b> <span id="humidityValue">--</span> %</div>
        <div class="col-md-4"><i class="fa-solid fa-hand-holding-water"></i> <b>Umidade do Solo:</b> <span id="soilMoistureValue">--</span> %</div>
        <div class="col-md-4"><i class="fa-solid fa-cloud"></i> <b>Níveis de CO2:</b> <span id="co2Value">--</span> ppm</div>
        <div class="col-md-4"><i class="fa-solid fa-sun"></i> <b>Luz:</b> <span id="lightValue">--</span> lux</div>
        <div class="col-md-4"><i class="fa-solid fa-seedling"></i> <b>pH do Solo:</b> <span id="phValue">--</span></div>
    </div>
</div>



<script>
function fetchData() {
    $.getJSON('data.php', function(data) {
        $('#tempValue').text(data.temperature);
        $('#humidityValue').text(data.humidity);
        $('#soilMoistureValue').text(data.soil_moisture);
        $('#co2Value').text(data.co2_levels);
        $('#lightValue').text(data.light_intensity);
        $('#phValue').text(data.soil_ph);
    });
}

$(document).ready(function() {
    fetchData(); // Carregar dados ao iniciar
    setInterval(fetchData, 1000); // Atualizar dados a cada 1 segundo
});
</script>

</body>
</html>
