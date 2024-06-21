<?php

namespace App\Http\Controllers;

use MongoDB\Client as MongoClient;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Log;

class SensorDashboardController extends Controller
{
    protected $collection;

    public function __construct()
    {
        try {
            $client = new MongoClient(env('DB_CONNECTION_STRING'));
            $this->collection = $client->selectCollection('estufa', 'sensors');
            Log::info('MongoDB connection established successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to connect to MongoDB: ' . $e->getMessage());
        }
    }

    public function index()
    {
        try {
            // Calcular o timestamp de 10 minutos atrás
            $tenMinutesAgo = Carbon::now()->subMinutes(10);

            Log::info('Timestamp for 10 minutes ago: ' . $tenMinutesAgo->toDateTimeString());

            // Conectar ao MongoDB e buscar dados dos últimos 10 minutos
            $cursor = $this->collection->find([
                'timestamp' => ['$gte' => new \MongoDB\BSON\UTCDateTime($tenMinutesAgo->timestamp * 1000)]
            ]);
            $sensors = iterator_to_array($cursor);

            Log::info('Number of sensors retrieved: ' . count($sensors));
            Log::info('Sensor data: ' . json_encode($sensors));

            // Passar os dados para a view
            return view('index', ['sensors' => $sensors]);
        } catch (\Exception $e) {
            Log::error('Error in index method: ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }
}
