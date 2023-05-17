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

Route::get('/token', [RentalController::class, 'createToken'])->name('token');
Route::get('/rentals', [RentalController::class, 'index'])->name('data');
Route::post('/rentals/store', [RentalController::class, 'store'])->name('tambah-data');
Route::patch('/rentals/{id}/update', [RentalController::class, 'update'])->name('update');
Route::get('/rentals/{id}', [RentalController::class, 'show'])->name('show');
Route::delete('/rentals/{id}/delete', [RentalController::class, 'destroy'])->name('hapus');
Route::get('/rentals/show/trash', [RentalController::class, 'trash'])->name('sampah');
Route::get('/rentals/show/trash/{id}', [RentalController::class, 'restore'])->name('restore');
Route::get('/rentals/show/trash/permanent/{id}', [RentalController::class, 'permanentDelete'])->name('permanentDelete');
