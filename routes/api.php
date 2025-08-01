<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [LoginController::class, 'loginDoApi']);
Route::get('login', function (Request $request) {
    return "";
});

Route::post('creditoPlanilla', [HomeController::class, 'creditoPlanilla']);
Route::post('obtenertoken', [HomeController::class, 'getToken']);






//Route::post('test', [ApiController::class, 'test']);