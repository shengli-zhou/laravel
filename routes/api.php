<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('shopcart/shopcart','ShopcartController@shopcart');
    Route::post('buycart','ShopcartController@buycart');
    Route::post('greed','ShopcartController@greed');
    Route::post('member_address','Member_AddressController@member_address');
    Route::post('address','Member_AddressController@address');
    Route::post('show','Member_AddressController@show');
    Route::post('cart_two','Cart_TwoController@cart_two');
    Route::post('cart_two1','Cart_TwoController@cart_two1');
    Route::post('add','Cart_TwoController@add');
    Route::get('index','PayController@index');
    Route::get('return','PayController@return');
    Route::get('notify','PayController@notify');
});
Route::get('users/{user}', function (App\User $user) {
    dd($user);
});

    
    Route::get('login/show','LoginController@show');
    Route::get('login/tree','LoginController@tree');
    Route::get('login/cate_gory','LoginController@cate_gory');
    Route::get('login/gfloor','LoginController@gfloor');
    Route::get('show/goods','ShowController@goods');
    Route::post('show/findware','ShowController@findware');
    
