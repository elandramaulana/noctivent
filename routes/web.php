<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseDataController;

Route::get('/', function () {
    return view('welcome');
});

// data firebase routes
Route::get('/firebase/test', [FirebaseDataController::class, 'testConnection']);
Route::get('/firebase/debug/all', [FirebaseDataController::class, 'debugAllData']);
Route::get('/firebase/dummy-data', [FirebaseDataController::class, 'getDummyData']);
Route::get('/firebase/summary', [FirebaseDataController::class, 'getTemperatureSummary']);


// vent routes
Route::get('/vent/get-status', [FirebaseDataController::class, 'getStatus'])->name('vent.get-status');
Route::post('/vent/update-status', [FirebaseDataController::class, 'updateStatus'])->name('vent.update-status');

