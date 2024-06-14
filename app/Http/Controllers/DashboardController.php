<?php

namespace App\Http\Controllers;

use MongoDB\Client as MongoClient;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Conectar ao MongoDB
        $client = new MongoClient(env('DB_CONNECTION_STRING'));

        // Selecionar a coleção 'sensors'
        $collection = $client->selectCollection('estufa', 'sensors');

        // Recuperar todos os documentos da coleção
        $cursor = $collection->find();
        $sensors = iterator_to_array($cursor);

        // Passar os dados para a view
        return view('index', ['sensors' => $sensors]);
    }
}
