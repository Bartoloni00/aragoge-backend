<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\PaymentsController;
use App\Http\Controllers\Api\PlanningsController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\SpecialityController;
use App\Http\Controllers\Api\SubscriptionsController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\ProfessionalController;
use Illuminate\Support\Facades\Route;

Route::controller(CategoriesController::class)
    ->prefix('categories')
    ->group(function(){
        Route::get('/','all');
        Route::get('/{id}','getByID')->whereNumber('id');
        Route::middleware(['auth:sanctum', 'authorizeRole:admin'])->group(function(){
            Route::post('/', 'create');
            Route::delete('/{id}', 'delete')->whereNumber('id');
            Route::patch('/{id}', 'update')->whereNumber('id');
        });
    });

Route::controller(UsersController::class)
    ->prefix('users')
    ->group(function(){
        Route::get('/', 'getUsers');// Se puede utilizar el parametro rol, el cual accepta 3 valores: atlete, admin, professional
        Route::get('/{id}','getByID')->whereNumber('id');

        Route::get('/{id}/subscriptions', 'getSubscriptions')
            ->whereNumber('id')
            ->middleware('role:atlete,id');

        Route::get('/{id}/plannings', 'getPlannings')
            ->whereNumber('id')
            ->middleware('role:professional,id');

        Route::patch('/update', 'update')
            ->middleware('auth:sanctum');

        Route::delete('/delete', 'delete')
            ->middleware('auth:sanctum');
    });

Route::controller(ProfessionalController::class)
    ->prefix('professionals')
    ->group(function(){
        Route::post('/profile', 'createProfessionalProfile')
            ->middleware(['auth:sanctum', 'authorizeRole:professional']);

        Route::patch('/profile', 'updateProfessionalProfile')
            ->middleware(['auth:sanctum', 'authorizeRole:professional']);
    });

Route::controller(SpecialityController::class)
    ->prefix('specialities')
    ->group(function(){
        Route::get('/', 'all');
        Route::get('/{id}', 'getByID')->whereNumber('id');
    });

Route::controller(PlanningsController::class)
    ->prefix('plannings')
    ->group(function(){
        Route::get('/', 'getPlannings');
        Route::get('/{id}', 'getPlanningByID')->whereNumber('id');
        Route::get('/{id}/subscriptions', 'getSubscriptionsForThisPlanning')->whereNumber('id');

        Route::delete('/{id}', 'delete')
            ->middleware(['auth:sanctum', 'authorizeRole:professional', 'isMyPlanning'])
            ->whereNumber('id');
    });

Route::controller(RolesController::class)
    ->prefix('roles')
    ->group(function(){
        Route::get('/', 'getRoles');
        Route::get('/{id}', 'getRolByID')->whereNumber('id');
    });
    
Route::controller(SubscriptionsController::class)
    ->prefix('subscriptions')
    ->group(function(){
        Route::get('/', 'getSubscriptions');
        Route::get('/{id}', 'getSubscriptionByID')->whereNumber('id');
    });

Route::controller(AuthController::class)->group(callback: function(): void{
    Route::post(uri: '/register', action: 'register');
    Route::post(uri: '/login', action: 'login');
    Route::post(uri: '/logout', action: 'logout')
        ->middleware(['auth:sanctum']);
});

Route::controller(PaymentsController::class)
    ->prefix('payments')
    ->group(function(){
        Route::get('/', 'getPayments');
        Route::get('/{id}', 'getPaymentByID')->whereNumber('id');
    });