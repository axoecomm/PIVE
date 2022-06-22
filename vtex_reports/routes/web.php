<?php

use App\Http\Controllers\EmpleadosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdenesController;
use App\Http\Controllers\ExtractorOrdenesVTEX;
use App\Http\Controllers\TransaccionesController;
use App\Http\Controllers\ConvertidorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Rutas sin autenticación, sólo URL token:

Route::get('/ordenesVTEX/extraer', [ExtractorOrdenesVTEX::class, 'extraer']);



// Rutas con autenticación requerida:

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/ordenes', [OrdenesController::class, 'ordenes'])->name('ordenes');


Route::middleware(['auth:sanctum', 'verified'])->get('/transacciones', function () {
    return view('transacciones');
})->name('transacciones');
Route::middleware(['auth:sanctum', 'verified'])->post('/transacciones', [TransaccionesController::class, 'transaccionesReport'])->name('transacciones');

Route::middleware(['auth:sanctum', 'verified'])->get('/empleados', [EmpleadosController::class, 'empleados'])->name('empleados');
Route::middleware(['auth:sanctum', 'verified'])->post('/empleados', [EmpleadosController::class, 'nuevoEmpleado'])->name('empleados');

Route::middleware(['auth:sanctum', 'verified'])->get('/empleadosBaja', [EmpleadosController::class, 'bajaEmpleado'])->name('empleadosBaja');
Route::middleware(['auth:sanctum', 'verified'])->post('/empleadosBaja', [EmpleadosController::class, 'bajaEmpleado'])->name('empleadosBaja');

Route::middleware(['auth:sanctum', 'verified'])->get('/empleadosCargaMasiva', function () {
    return view('empleadosCargaMasiva');
})->name('empleadosCargaMasiva');

Route::middleware(['auth:sanctum', 'verified'])->post('/empleadosCargaMasiva', [EmpleadosController::class, 'importExcel'])->name('empleadosCargaMasiva');

Route::middleware(['auth:sanctum', 'verified'])->get('/empleadosDataTienda', [EmpleadosController::class, 'empleadosDataTienda'])->name('empleadosDataTienda');
Route::middleware(['auth:sanctum', 'verified'])->post('/empleadosDataTienda', [EmpleadosController::class, 'dataTableCarga'])->name('empleadosDataTienda');

Route::middleware(['auth:sanctum', 'verified'])->get('/convertidor', [ConvertidorController::class, 'convertidor'])->name('convertidor');
Route::middleware(['auth:sanctum', 'verified'])->post('/convertidor', [ConvertidorController::class, 'convertidorURL'])->name('convertidor');

Route::middleware(['auth:sanctum', 'verified'])->get('/convertidorJson', [ConvertidorController::class, 'convertidorJson'])->name('convertidorJson');
Route::middleware(['auth:sanctum', 'verified'])->post('/convertidorJson', [ConvertidorController::class, 'archivoJson'])->name('convertidorJson');


//Route::middleware(['auth:sanctum', 'verified'])->get('/empleados', [EmpleadosController::class, 'getEmpleados'])->name('empleados');
