<?php

use App\Http\Controllers\PaginaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminCommentController;
use App\Models\User;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [PaginaController::class, 'index'])->name('index');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/poslog', function () {
    return view('poslog');
})->middleware(['auth', 'verified'])->name('poslog');

Route::post('/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');
Route::get('/', [HomeController::class, 'index'])->name('index');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/comments', [AdminCommentController::class, 'index'])->name('admin.comments.index');
    Route::post('/comments/update/{comment}', [AdminCommentController::class, 'update'])->name('admin.comments.update');
    Route::post('/comments/import', [AdminCommentController::class, 'import'])->name('admin.comments.import');
    Route::get('/comments/export', [AdminCommentController::class, 'export'])->name('admin.comments.export');
});

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/comments/approved', [HomeController::class, 'showApprovedComments'])->name('comments.approved');
Route::post('/comments', [HomeController::class, 'store'])->name('comments.store');

Route::get('/comments', [HomeController::class, 'showApprovedComments'])->name('comments.approved');

