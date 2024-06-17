<?php
use App\Http\Controllers\PaginaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SensorDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdmPanelController;
use App\Http\Controllers\EstufasController;
use App\Http\Controllers\RelatoriosController;

use MongoDB\Client as MongoClient;



//Route::get('/', [DashboardController::class, 'index'])->name('index');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index')->middleware('auth');

Route::get('/adm', [AdmPanelController::class, 'index'])->name('adm')->middleware('auth');

// Rotas de autenticação
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/', [SensorDashboardController::class, 'index'])->name('index');

// Rotas protegidas por autenticação

    Route::get('/estufa1', [EstufasController::class, 'index'])->name('estufa1')->middleware('auth');
    Route::get('/relatoriotemp', [RelatoriosController::class, 'index'])->name('relatoriotemp')->middleware('auth');


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


