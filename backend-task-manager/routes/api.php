<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json([
        'message' => 'Laravel API is working!',
        'status' => 'success'
    ]);
});

Route::post('/users', [UserController::class, 'store']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::match(
    ['put', 'patch'],
    '/users/{user}',
    [UserController::class, 'update']
);
Route::delete('/users/{user}', [UserController::class, 'destroy']);
