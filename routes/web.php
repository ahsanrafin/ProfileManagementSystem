<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterUserController;

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
    return view('welcome');
});

Auth::routes();

//Laravel default authentication middleware
Route::group(['middleware' => 'auth'], function () {   
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    /* Custom middleware for checking that current authenticated 
    user can edit his/her inforamtion */ 
    Route::group(['middleware' => 'edit.user'], function(){
        Route::get('/user/edit/{id}', [RegisterUserController::class, 'edit'])->name('user.edit');
        Route::post('/user/edit/{id}', [RegisterUserController::class, 'update'])->name('user.update');
    });
    /* Custom middleware for checking that current authenticated 
    user can not delete his/herself */
    Route::group(['middleware' => 'delete.user'], function(){
        Route::post('/user/delete/{id}', [RegisterUserController::class, 'destroy'])->name('user.destroy');        
    });
});

//Public route
Route::get('/users', [RegisterUserController::class, 'index'])->name('user.index');
