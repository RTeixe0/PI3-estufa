<?php
// Simula dados obtidos de sensores
echo json_encode([
    'temperature' => rand(23, 28),
    'humidity' => rand(40, 60),
    'soil_moisture' => rand(30, 50),
    'co2_levels' => rand(300, 400),
    'light' => rand(100, 200),
    'soil_ph' => rand(5, 7)
]);
