<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(HomeController::class)->group(function(){
	Route::get('/', 'index')->name('index');
	Route::get('/how-it-works', 'howItWorks')->name('how.it.works');
	Route::post('/save-text', 'saveText')->name('save.text');
});

Route::controller(AuthController::class)->group(function(){
	Route::get('/login', 'login')->name('login');
	Route::get('/register', 'register')->name('register');
	Route::post('/signin', 'signin')->name('signin');
	Route::post('/signup', 'signup')->name('signup');
});

Route::controller(FileController::class)->group(function(){
	Route::post('/file/upload', 'upload')->name('file.upload');
	Route::delete('/file/delete/{id}', 'delete')->name('file.delete');
	Route::delete('/file/delete-all', 'deleteAll')->name('file.delete.all');
});
