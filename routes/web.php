<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\KardexController;
use Illuminate\Support\Facades\Route;

// Ruta principal (welcome)
Route::get('/', function () {
    return view('welcome'); // Vista principal de bienvenida
});

// Ruta protegida para el menú (ahora principal)
Route::middleware('auth')->get('/menu', [DashboardController::class, 'menu'])->name('menu');

// Rutas de perfil (protegidas)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas públicas para autenticación
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Ruta para logout
Route::middleware('auth')->post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rutas de CRUD para módulos existentes
Route::middleware('auth')->group(function () {
    Route::resource('clientes', ClienteController::class);
    Route::resource('proveedor', ProveedorController::class);
    Route::resource('productos', ProductoController::class);
    Route::resource('compras', CompraController::class);
    Route::resource('kardex', KardexController::class);
    Route::resource('ventas', VentaController::class);
});

// Archivo de rutas adicionales de autenticación generadas por Breeze
require __DIR__.'/auth.php';
