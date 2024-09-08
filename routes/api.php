<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::controller(CategoriesController::class)->group(function(){
    Route::get('/categories','all');
});

Route::controller(UsersController::class)->group(function(){
    Route::get('/users', 'getUsers');// Se puede utilizar el parametro rol, el cual accepta 3 valores: atlete, admin, professional
    Route::get('users/{id}','getByID');
});