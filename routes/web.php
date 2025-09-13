<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptivePortalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CaptiveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

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

// Rotas do Portal Captivo
Route::middleware('web')->group(function () {
    Route::get('/', [CaptiveController::class, 'showLogin'])->name('captive.login');
    Route::post('/authorize', [CaptiveController::class, 'authorizeClient'])->name('captive.authorize');
    Route::get('/authorize', function() {
        return redirect()->route('captive.login');
    });
    Route::get('/logout', [CaptiveController::class, 'logout'])->name('captive.logout');
});

// Rotas originais do Portal Captivo
Route::get('/captive/login', [CaptivePortalController::class, 'showLoginForm'])->name('captive.original.login');
Route::post('/captive/register', [CaptivePortalController::class, 'register'])->name('captive.register');
Route::get('/captive/success', [CaptivePortalController::class, 'showSuccess'])->name('captive.success');

// Rota do Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/hotspot-detect.html', function () {
    return response("Success", 200)
        ->header('Content-Type', 'text/plain');
});
