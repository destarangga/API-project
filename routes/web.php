<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentalController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [RentalController::class, 'createToken']);
Route::get('/rentals', [RentalController::class, 'index']);
Route::post('/rentals/store', [RentalController::class, 'store']);
Route::patch('/rentals/{id}/update', [RentalController::class, 'update']);
Route::get('/rentals/{id}', [RentalController::class, 'show']);
Route::delete('/rentals/{id}/delete', [RentalController::class, 'destroy']);
Route::get('/rentals/show/trash', [RentalController::class, 'trash']);
Route::get('/rentals/show/trash/{id}', [RentalController::class, 'restore']);
Route::get('/rentals/show/trash/permanent/{id}', [RentalController::class, 'permanentDelete']);
