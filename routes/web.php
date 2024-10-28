<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\HistorialComprasController;

Route::get('/', function () {
    return view('welcome');
});

// Inicio de Aplicación
Route::get('/dashboard', [ComprasController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// CRUD de Productos
Route::get('/Inventario', [InventarioController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('Inventario');

Route::get('/productos/create', [InventarioController::class, 'create'])
    ->middleware(['auth', 'verified'])
    ->name('productos.create');

Route::post('/productos', [InventarioController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('productos.store');

Route::get('/productos/{producto}/edit', [InventarioController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->name('productos.edit');

Route::put('/productos/{producto}', [InventarioController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('productos.update');

Route::delete('/productos/{producto}', [InventarioController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('productos.destroy');

// Carrito de Compras
Route::post('/compras/agregar', [ComprasController::class, 'agregar'])
    ->middleware(['auth', 'verified'])
    ->name('compras.agregar');

Route::get('/carrito', [ComprasController::class, 'verCarrito'])
    ->middleware(['auth', 'verified'])
    ->name('carrito.ver');

Route::get('/paypal/pago', [PayPalController::class, 'crearPago'])
    ->middleware(['auth', 'verified'])
    ->name('paypal.crearPago');

Route::get('/paypal/captura', [PayPalController::class, 'capturarPago'])
    ->middleware(['auth', 'verified'])
    ->name('paypal.capturarPago');

// Ruta para manejar el éxito del pago
Route::get('/paypal/success', [PayPalController::class, 'capturarPago'])
    ->name('paypal.success');

// Ruta para manejar la cancelación del pago
Route::get('/paypal/cancel', function () {
    return redirect()->route('dashboard')->with('error', 'El pago fue cancelado.');
})->name('paypal.cancel');

Route::get('/compras/finalizar', [ComprasController::class, 'finalizar'])
    ->middleware(['auth', 'verified'])
    ->name('compras.finalizar');

// Historial de Compras
Route::get('/historial', [HistorialComprasController::class, 'historialCompras'])
    ->middleware(['auth', 'verified'])
    ->name('historial');

Route::get('/historial-compras/comprobante/{captureId}', [HistorialComprasController::class, 'obtenerComprobantePaypal'])
    ->middleware(['auth', 'verified'])
    ->name('obtenerComprobantePaypal');

Route::get('/paypal/comprobante/{captureId}', [HistorialComprasController::class, 'obtenerComprobantePaypal'])
    ->middleware(['auth', 'verified'])
    ->name('paypal.comprobante');

// Configuración del perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
