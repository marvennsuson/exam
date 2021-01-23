<?php

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
    return view('welcome');
});

Route::resource('/exam', 'CustomerController');
<<<<<<< HEAD
  // Route::get('/exam/viewall', 'CustomerController@viewAll')->name('exam.viewall');
=======
// Route::get('/exam/viewall', 'CustomerController@viewAll')->name('exam.viewall');
>>>>>>> 8a4fe86468d9593e4ff915b5325fe41e3689268a
