<?php

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

// Make route patients
Route::group([
    'as' => 'patients.',
    'prefix' => 'patients'
], function () {
    // with method apiResource for index, store, show, update, and destroy
    Route::apiResource('/', PatientController::class);
    // Search by name
    Route::get('/search/{name}', [PatientController::class, 'search']);
    // Where status is positive
    Route::get('/status/positive', [PatientController::class, 'positive']);
    // Where status is recovery
    Route::get('/status/recovered', [PatientController::class, 'recovered']);
    // Where status is dead
    Route::get('/status/dead', [PatientController::class, 'dead']);
});
