<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [UserController::class,'index'])->name('dashboard');
});


//route for users save
Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('users/create', [UserController::class,'create'])->name('users.create');
    Route::post('users/create', [UserController::class,'store'])->name('users.store');
    Route::post('users/create/upload', [UserController::class,'storeUpload'])->name('users.storeUpload');
    Route::get('edit/{id}', [UserController::class,'showData'])->name('show');
    Route::post('edit', [UserController::class,'update'])->name('update.user');
    Route::post('delete', [UserController::class,'delete'])->name('delete.user');
    Route::get('users/export', [UserController::class, 'export'])->name('export');

});

