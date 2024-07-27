<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\clienteController;
use App\Http\Controllers\Api\productoController;
use App\Http\Controllers\Api\facturaController;
// Api Clientes

Route::get("/clientes", [clienteController::class,"index"]);

Route::get("/clientes/{id}", [clienteController::class,"show"]);

Route::post('/clientes', [clienteController::class,'store']);

Route::put("/clientes/{id}", [clienteController::class,"update"]);

Route::delete("/clientes/{id}", [clienteController::class,"destroy"]);

// Api Productos

Route::get("/productos", [productoController::class,"index"]);

Route::get("/productos/{id}", [productoController::class,"show"]);

Route::post('/productos', [productoController::class,'store']);

Route::put("/productos/{id}", [productoController::class,"update"]);

Route::delete("/productos/{id}", [productoController::class,"destroy"]);

// Api Facturas
Route::get("/facturas", [facturaController::class, 'index']);

Route::get("/facturas/{id}", [facturaController::class,"show"]);

Route::post('/facturas', [facturaController::class,'store']);

Route::put("/facturas/{id}", [facturaController::class,"update"]);

Route::delete("/facturas/{id}", [facturaController::class,"destroy"]);