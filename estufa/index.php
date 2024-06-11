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
        <!-- Os dados dos sensores serão carregados aqui -->
    </div>
</div>


<script>
function fetchData() {
    $('#sensorData').html('<div class="col-12">s</div>');
    $.getJSON('data.php', function(data) {
        $('#sensorData').html(`
            <div class="col-md-4"><i class="fa-solid fa-temperature-half"></i> <b>Temperatura:</b> ${data.temperature} °C</div>
            <div class="col-md-4"><i class="fa-solid fa-droplet"></i> <b>Umidade:</b> ${data.humidity} %</div>
            <div class="col-md-4"><i class="fa-solid fa-hand-holding-water"></i> <b>Umidade do Solo:</b> ${data.soil_moisture} %</div>
            <div class="col-md-4"><i class="fa-solid fa-cloud"></i> <b>Níveis de CO2:</b> ${data.co2_levels} ppm</div>
            <div class="col-md-4"><i class="fa-solid fa-sun"></i> <b>Luz:</b> ${data.light} lux</div>
            <div class="col-md-4"><i class="fa-solid fa-seedling"></i> <b>pH do Solo:</b> ${data.soil_ph}</div>
        `);
    });
}
$(document).ready(function() {
    fetchData(); // Carregar dados ao iniciar
    setInterval(fetchData, 1000); // Atualizar dados a cada 1 segundo
});
</script>

</body>
</html>
