<?php

namespace App\Http\Controllers;

use MongoDB\Client as MongoClient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    protected $collection;

    public function __construct()
    {
        $client = new MongoClient(env('DB_CONNECTION_STRING'));
        $this->collection = $client->selectCollection('estufa', 'sensors');
    }

    public function index()
    {
        try {
            // Calcular o timestamp de 10 minutos atrás
            $tenMinutesAgo = Carbon::now()->subMinutes(10);

            // Conectar ao MongoDB e buscar dados dos últimos 10 minutos
            $cursor = $this->collection->find([
                'timestamp' => ['$gte' => new \MongoDB\BSON\UTCDateTime($tenMinutesAgo->timestamp * 1000)]
            ]);
            $sensors = iterator_to_array($cursor);

            return view('admin.index', ['sensors' => $sensors]);
        } catch (\Exception $e) {
            Log::error('Error in index method: ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }
}
