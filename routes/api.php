<?php

use App\Http\controllers\api\AuthController;
use App\Http\controllers\api\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);



Route::group(['middleware'=> ['auth:sanctum']], function (){
    Route::resource('/tasks', TasksController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});