<?php
use App\Http\Controllers\PaginaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminCommentController;

// Rota inicial
Route::get('/', [PaginaController::class, 'index'])->name('index');

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

// Rota de comentários
Route::post('/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/comments/approved', [HomeController::class, 'showApprovedComments'])->name('comments.approved');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/comments', [AdminCommentController::class, 'index'])->name('admin.comments.index');
    Route::post('/comments/update/{comment}', [AdminCommentController::class, 'update'])->name('admin.comments.update');
});