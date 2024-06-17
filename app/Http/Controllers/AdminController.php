<?php

namespace App\Http\Controllers;

use MongoDB\Client as MongoClient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use MongoDB\Client as MongoDBClient;

class AdminController extends Controller
{
    protected $collection;

    public function __construct()
    {
        $client = new MongoClient(env('mongodb://localhost:27017/'));
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
        $mongo = new MongoDBClient(env('mongodb://localhost:27017/'));
        $collection = $mongo->estufa->sensors;

        // Obter os dados do MongoDB
        $sensors = $collection->find()->toArray();

        return view('admin.index', compact('sensors'));
        
  
    }
    public function getMongoData()
    {
        // Conectar ao MongoDB
        $mongo = new MongoDBClient(env('mongodb://localhost:27017/'));
        $collection = $mongo->estufa->sensors;

        // Obter os dados do MongoDB
        $sensors = $collection->find()->toArray();

        return response()->json($sensors);
    }
}
