<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClinicalSheetController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConsentController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BookingController;
use App\Models\Service;
use App\Http\Controllers\AiController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

    Route::resource('appointments', AppointmentController::class);

    // ... dentro del grupo auth
    Route::get('/appointments/{appointment}/start', [AppointmentController::class, 'startSession'])->name('appointments.start');

    Route::post('/appointments/{appointment}/sheet', [ClinicalSheetController::class, 'store'])->name('clinical-sheets.store');

    Route::get('/appointments/{appointment}/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/appointments/{appointment}/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/appointments/{appointment}/consent', [ConsentController::class, 'create'])->name('consents.create');
    Route::post('/appointments/{appointment}/consent', [ConsentController::class, 'store'])->name('consents.store');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');

    Route::post('/appointments/{appointment}/photos', [PhotoController::class, 'store'])->name('photos.store');

    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::post('/inventory/{product}/add', [InventoryController::class, 'addStock'])->name('inventory.add');

    Route::get('/services/{service}/recipe', [ServiceController::class, 'editRecipe'])->name('services.recipe.edit');
    Route::post('/services/{service}/recipe', [ServiceController::class, 'updateRecipe'])->name('services.recipe.update');

    Route::post('/ai/enhance', [AiController::class, 'enhance'])->name('ai.enhance');

    Route::get('/appointments/{appointment}/attend', [AppointmentController::class, 'attend'])->name('appointments.attend');
});

    // 1. PÁGINA DE BIENVENIDA (Landing Page)
Route::get('/', function () {
    // Mostramos 3 servicios aleatorios o destacados en la portada
    $services = Service::inRandomOrder()->take(3)->get();
    return view('welcome', compact('services'));
})->name('welcome');

// 2. FORMULARIO DE RESERVA
Route::get('/reservar', [BookingController::class, 'create'])->name('booking.create');
Route::post('/reservar', [BookingController::class, 'store'])->name('booking.store');
Route::get('/reserva-exitosa', [BookingController::class, 'success'])->name('booking.success');


require __DIR__.'/auth.php';
