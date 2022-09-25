<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyCasesController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TypesController;
use App\Http\Controllers\Api\CasesController;
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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {

    Route::post('login', [AuthController::class,'login']);


//    Route::post('logout', 'AuthController@logout');
//    Route::post('refresh', 'AuthController@refresh');
//    Route::post('me', 'AuthController@me');

});

Route::group(['middleware' => 'jwt.verify', 'prefix' => 'admin'], function () {

    Route::get('types', [TypesController::class,'allTypes']);
    Route::post('type/add', [TypesController::class,'addType']);
    Route::post('type/update', [TypesController::class,'updateType']);
    Route::post('type/delete', [TypesController::class,'deleteType']);

    // cases route
    Route::get('cases', [CasesController::class, 'allCases']);
    Route::get('case/specific', [CasesController::class, 'specificCase']);
    Route::post('cases/add', [CasesController::class, 'addCase']);
    Route::post('cases/update', [CasesController::class, 'updateCase']);
    Route::post('cases/delete', [CasesController::class, 'deleteCase']);

    // Company cases route
    Route::get('company/cases', [CompanyCasesController::class, 'allCases']);
    Route::get('company/case/specific', [CompanyCasesController::class, 'specificCase']);
    Route::post('company/case/add', [CompanyCasesController::class, 'addCase']);
    Route::post('company/case/update', [CompanyCasesController::class, 'updateCase']);
    Route::post('company/case/delete', [CompanyCasesController::class, 'deleteCase']);

    // Tasks route
    Route::get('tasks', [TaskController::class, 'allTasks']);
    Route::get('task/specific', [TaskController::class, 'specificTask']);
    Route::post('task/add', [TaskController::class, 'addTask']);
    Route::post('task/update', [TaskController::class, 'updateTask']);
    Route::post('task/delete', [TaskController::class, 'deleteTask']);
    Route::post('task/update/status', [TaskController::class, 'updateTaskStatus']);



    // Staff Section
    Route::get('staff', [AdminController::class, 'allStaff']);
    Route::get('staff/specific', [AdminController::class, 'specificStaff']);
    Route::post('staff/add', [AdminController::class, 'addStaff']);
    Route::post('staff/delete', [AdminController::class, 'deleteStaff']);
    Route::post('staff/update', [AdminController::class, 'updateStaff']);

    //Clients Section
    Route::get('clients', [AdminController::class, 'allClients']);
    Route::get('client/specific', [AdminController::class, 'specificClient']);
    Route::post('client/add', [AdminController::class, 'addClient']);
    Route::post('client/delete', [AdminController::class, 'deleteClient']);
    Route::post('client/update', [AdminController::class, 'updateClient']);


    // Roles Section
    Route::get('staff/roles', [AdminController::class, 'staffRoles']);

    // Library
    Route::get('library/all', [AdminController::class, 'allLibraryItems']);
    Route::post('library/add', [AdminController::class, 'addLibraryItem']);
    Route::post('library/delete', [AdminController::class, 'deleteLibraryItem']);

});
