@extends('layouts.app')

@section('title', 'Dados dos Sensores')

@section('content')
<div class="container mt-5">
    <h1>Dados dos Sensores</h1>
    @if (empty($sensors))
        <p>Nenhum dado encontrado.</p>
    @else
        @foreach ($sensors as $sensor)
            <div>
                <p>Temperatura: {{ $sensor['temperature'] }} °C</p>
                <p>Umidade: {{ $sensor['humidity'] }} %</p>
                <p>Umidade do Solo: {{ $sensor['soil_moisture'] }} %</p>
                <p>Níveis de CO2: {{ $sensor['co2_levels'] }} ppm</p>
                <p>Intensidade de Luz: {{ $sensor['light_intensity'] }} lx</p>
                <p>pH do Solo: {{ $sensor['soil_ph'] }}</p>
                <p>Timestamp: {{ \Carbon\Carbon::parse($sensor['timestamp']->toDateTime())->toDateTimeString() }}</p>
            </div>
        @endforeach
    @endif
</div>
@endsection
