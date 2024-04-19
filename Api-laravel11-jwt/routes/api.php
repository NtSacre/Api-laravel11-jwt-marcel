<?php

use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\RoleController;
use App\Http\Middleware\isSuperAdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);
//Route protected 
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('profile', [ApiController::class, 'profile']);
    Route::get('refreshToken', [ApiController::class, 'refreshToken']);
});

Route::apiResource('role', RoleController::class)->middleware('superAdmin');


Route::get('loginin', function (){
return response()->json([
    'error' => 'Unauthenticated',
], 404);
})->name('login');
