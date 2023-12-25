<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripController;
use App\Http\Controllers\SeatAllocationController;

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
})->name('home');
Route::post('trips/by-date', [TripController::class, 'tripsByDate'])->name('trips-by-date');
Route::post('trips/get-booked-seats', [TripController::class, 'bookedSeats'])->name('get-booked-seats');
Route::resource('trips', TripController::class);


Route::resource('seat-allocation', SeatAllocationController::class);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
