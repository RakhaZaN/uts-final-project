<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Make route authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protect routes
// Must be authanticated for access routes inside
Route::group([
    'middleware' => 'auth:sanctum'
], function () {

    // with method apiResource for index, store, show, update, and destroy
    Route::apiResource('/patients', PatientController::class);
    // Search by name
    Route::get('/patients/search/{name}', [PatientController::class, 'search']);
    // Where status is positive
    Route::get('/patients/status/positive', [PatientController::class, 'positive']);
    // Where status is recovery
    Route::get('/patients/status/recovered', [PatientController::class, 'recovered']);
    // Where status is dead
    Route::get('/patients/status/dead', [PatientController::class, 'dead']);
});
