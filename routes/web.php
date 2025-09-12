<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptivePortalController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redireciona a raiz para a página de login do portal captivo
Route::get('/', function () {
    return redirect()->route('captive.login');
});

// Rotas do Portal Captivo
Route::get('/captive/login', [CaptivePortalController::class, 'showLoginForm'])->name('captive.login');
Route::post('/captive/register', [CaptivePortalController::class, 'register'])->name('captive.register');
Route::get('/captive/success', [CaptivePortalController::class, 'showSuccess'])->name('captive.success');

// Rota do Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
