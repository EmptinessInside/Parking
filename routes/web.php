<?php

use Illuminate\Support\Facades\Route;

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
    return view('index');
});

Route::post('/create_client', [\App\Http\Controllers\ClientController::class, 'store']);
Route::post('/get_client_data', [\App\Http\Controllers\ClientController::class, 'show']);
Route::post('/clients_list', [\App\Http\Controllers\ClientController::class, 'index']);
Route::post('/edit_client', [\App\Http\Controllers\ClientController::class, 'edit']);

Route::get('/get-cars-count', [\App\Http\Controllers\CarController::class, 'cars_count']);
Route::post('/remove_car', [\App\Http\Controllers\CarController::class, 'remove']);
