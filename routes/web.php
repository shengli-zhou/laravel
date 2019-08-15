<?php

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



Route::get('login', function () {
    return view('login');
});

// Route::get('loginaction', function () {
//     return view('loginAction');
// });
// Route::get('loginaction','LoginController@loginAction');



Route::get('show', function () {
    return view('show');
});


Route::get('loginAction','LoginController@loginAction');

Route::get('login/loginout','LoginController@loginout');


Route::get('show/users','ShowController@users');
Route::get('/aa', function () {
   echo $hashed = Hash::make('zsl');
});