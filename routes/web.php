<?php
use App\Http\Controllers\PaginaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use MongoDB\Client as MongoClient;

// Rota inicial
Route::get('/', [PaginaController::class, 'index'])->name('index');

Route::get('/', [DashboardController::class, 'index'])->name('index');


// Rotas de autenticação
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rota pós login
Route::get('/poslog', function () {
    return view('poslog');
})->middleware(['auth', 'verified'])->name('poslog');


Route::get('/test-mongodb', function () {
    // Conectar ao MongoDB
    $client = new MongoClient(env('DB_CONNECTION_STRING'));

    // Selecionar a coleção 'users'
    $collection = $client->selectCollection('nome_do_seu_banco_de_dados', 'users');

    // Inserir um documento na coleção
    $collection->insertOne(['name' => 'Test User']);

    // Recuperar todos os documentos da coleção
    $cursor = $collection->find();
    $users = iterator_to_array($cursor);

    // Retornar os documentos como JSON
    return response()->json($users);
});