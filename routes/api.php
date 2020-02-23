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
Route::get('test-api-route', function(){ return "API ROUTES ARE WORKING!"; });


Route::post('authentication/{action}', 'AuthController@create');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api']], function (){ 
	Route::post('authentication/user/{action}', 'AuthController@create');
	Route::post('authentication-check', 'AuthController@show');

	Route::get('get-all-users', 'UserController@show');
	Route::post('create-new-user', 'UserController@create');
	Route::post('update-user-status/{action}', 'UserController@update');

	Route::get('get-all-items', 'InventoryController@show');
	Route::post('create-new-item', 'InventoryController@create');
	Route::post('update-item', 'InventoryController@update');

	Route::get('get-branches', 'BranchController@show');
	Route::get('get-branch-info', 'BranchController@index');
	Route::post('create-branch', 'BranchController@create');
	Route::post('update-branch', 'BranchController@update');
});
