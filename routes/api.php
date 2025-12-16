<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MobileController;

// --- RUTAS PÚBLICAS ---
// URL: http://tu-ip/api/login
Route::post('/login', [MobileController::class, 'login']);

// URL: http://tu-ip/api/services
Route::get('/services', [MobileController::class, 'services']);


// --- RUTAS PROTEGIDAS (Necesitan Token) ---
Route::middleware('auth:sanctum')->group(function () {
    
    // Obtener datos del usuario logueado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Ver mis citas
    Route::get('/my-appointments', [MobileController::class, 'myAppointments']);
});