<?php

use App\Http\Controllers\API\BusinessController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('business/{id}', [BusinessController::class, 'getBusinessDetails']);
Route::post('business', [BusinessController::class, 'store']);
Route::put('business/{id}', [BusinessController::class, 'update']);
