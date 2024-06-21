<?php
// URL do endpoint da API que fornece os dados dos sensores
$url = 'http://localhost:5000/api/sensors';

// Inicializa uma sessão cURL
$ch = curl_init();

// Configura a URL de requisição e outras opções
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Retorna a resposta como uma string
curl_setopt($ch, CURLOPT_HEADER, false);         // Não inclui o cabeçalho na saída

// Executa a sessão cURL
$response = curl_exec($ch);

// Verifica se houve algum erro durante a execução
if(curl_errno($ch)) {
    echo 'Erro na requisição: ' . curl_error($ch);
}

// Fecha a sessão cURL
curl_close($ch);

// Imprime a resposta
echo $response;
?>
