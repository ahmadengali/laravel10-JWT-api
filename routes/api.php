<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
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

//Api Routs//
// <the url should be /api/register>
route::post('register', [ApiController::class, "register"]);
route::post('login', [ApiController::class, "login"]);

Route::group([
    "middleware" => ["auth:api"]
], function(){
    route::get('profile', [ApiController::class, "profile"]);
    route::get('refresh', [ApiController::class, "refreshToken"]);
    route::get('logout', [ApiController::class, "logout"]);
});