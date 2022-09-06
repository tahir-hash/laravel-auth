<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard',[UserController::class, 'index'])->middleware(['auth'])->name('dashboard');

/* Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/private', function (){
        return 'je suis un admin';
    });
}); */

/* Route::middleware(['auth','role:client'])->group(function(){
    Route::get('/public', function (){
        return 'je suis un client';
    });
}); */

Route::get('/public', [ClientController::class, 'index']);


