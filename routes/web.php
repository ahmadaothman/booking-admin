<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TripBookingController;



Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
// Users
Route::get('/users', [UserController::class, 'userList'])->name('users');
Route::get('/users/add', [UserController::class, 'userForm'])->name('addUser');
Route::post('/users/add', [UserController::class, 'userForm'])->name('addUser');
Route::get('/users/edit', [UserController::class, 'userForm'])->name('editUser');
Route::post('/users/edit', [UserController::class, 'userForm'])->name('editUser');
Route::post('/users/remove', [UserController::class, 'remove'])->name('removeUsers');

Route::get('/users/balance', [UserController::class, 'balanceList'])->name('userBalance');
Route::get('/users/balance/add', [UserController::class, 'balanceForm'])->name('addUserBalance');
Route::post('/users/balance/add', [UserController::class, 'balanceForm'])->name('addUserBalance');
Route::get('/users/balance/edit', [UserController::class, 'balanceForm'])->name('editUserBalance');
Route::post('/users/balance/edit', [UserController::class, 'balanceForm'])->name('editUserBalance');

// Vehicles
Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles');
Route::get('/vehicles/add', [VehicleController::class, 'form'])->name('addVehicle');
Route::post('/vehicles/add', [VehicleController::class, 'form'])->name('addVehicle');
Route::get('/vehicles/edit', [VehicleController::class, 'form'])->name('editVehicle');
Route::post('/vehicles/edit', [VehicleController::class, 'form'])->name('editVehicle');
Route::post('/vehicles/remove', [VehicleController::class, 'remove'])->name('removeVehicles');
// Trips
Route::get('/trips', [TripController::class, 'index'])->name('trips');
Route::get('/trips/add', [TripController::class, 'form'])->name('AddTrip');
Route::get('/trips/edit', [TripController::class, 'form'])->name('EditTrip');
Route::post('/trips/add', [TripController::class, 'form'])->name('AddTrip');
Route::post('/trips/edit', [TripController::class, 'form'])->name('EditTrip');
Route::post('/trips/remove', [TripController::class, 'remove'])->name('removeTrips');
// auto suggest
Route::get('/trips/search/pickup', [TripController::class, 'getPickappLocations'])->name('search_pickup');
Route::get('/trips/search/destination', [TripController::class, 'getDestinations'])->name('searh_destination');
// Booking
Route::get('/booking/list/', [BookingController::class, 'index'])->name('booking');
Route::get('/booking/add', [BookingController::class, 'form'])->name('AddBooking');
Route::get('/booking/edit', [BookingController::class, 'form'])->name('EditBooking');
Route::post('/booking/add', [BookingController::class, 'form'])->name('AddBooking');
Route::post('/booking/edit', [BookingController::class, 'form'])->name('EditBooking');
Route::post('/booking/remove', [BookingController::class, 'remove'])->name('removeBooking');

// Booking
Route::get('/booking/trips/list', [TripBookingController::class, 'index'])->name('Tripbooking');
Route::get('/booking/trips/add', [TripBookingController::class, 'form'])->name('AddTripBooking');
Route::get('/booking/trips/edit', [TripBookingController::class, 'form'])->name('EditTripBooking');
Route::post('/booking/trips/add', [TripBookingController::class, 'form'])->name('AddTripBooking');
Route::post('/booking/trips/edit', [TripBookingController::class, 'form'])->name('EditTripBooking');
Route::post('/booking/trips/remove', [TripBookingController::class, 'remove'])->name('removeTripBooking');


