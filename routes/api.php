<?php

use App\Http\Controllers\CarneController;
use Illuminate\Support\Facades\Route;


Route::post('/carne', [CarneController::class, 'create']);
Route::get('/carne/{id}', [CarneController::class, 'getParcelas']);
