<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseDataController;

Route::get('/', function () {
    return view('welcome');
});

// Test connection
Route::get('/firebase/test', [FirebaseDataController::class, 'testConnection']);

// Debug: See all data structure
Route::get('/firebase/debug/all', [FirebaseDataController::class, 'debugAllData']);

// Get data from specific path
Route::get('/firebase/debug/path/{path}', [FirebaseDataController::class, 'getDataFromPath'])->where('path', '.*');

// Get all dummy data
Route::get('/firebase/dummy-data', [FirebaseDataController::class, 'getDummyData']);

// Get data by date
Route::get('/firebase/dummy-data/date/{date}', [FirebaseDataController::class, 'getDataByDate']);

// Get data by hour
Route::get('/firebase/dummy-data/hour/{hour}', [FirebaseDataController::class, 'getDataByHour']);

// Get temperature/humidity summary
Route::get('/firebase/summary', [FirebaseDataController::class, 'getTemperatureSummary']);

// Get latest data
Route::get('/firebase/latest', [FirebaseDataController::class, 'getLatestData']);

// Add new data
Route::post('/firebase/dummy-data', [FirebaseDataController::class, 'addData']);

// Clear all data (be careful!)
Route::delete('/firebase/dummy-data', [FirebaseDataController::class, 'clearData']);
