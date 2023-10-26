<?php

use App\Http\Controllers\PhaseController;
use App\Http\Controllers\TaskController;
use Illuminate\Contracts\Routing\Registrar;
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

Route::group(['middleware' => ['auth:sanctum']], function (Registrar $route) {
    $route->get('/user', fn(Request $request) => $request->user());

    $route->group(['controller' => TaskController::class], function (Registrar $route) {
        $route->group(['prefix' => 'tasks'], function (Registrar $route) {
            $route->get('', 'index');
            $route->post('', 'store');
            $route->delete('{task}', 'destroy');
            $route->put('{task}', 'update');
        });

        $route->get('/users', 'users');
    });

    $route->group(['prefix' => 'phases', 'controller' => PhaseController::class], function (Registrar $route) {
        $route->get('{phase}', [TaskController::class, 'show']);
        $route->delete('{phase}', 'destroy');
        $route->put('{phase}/set-completable', 'setCompletable');
    });
});


