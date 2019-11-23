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

Route::get('/', function () { return view('base'); });
Route::get('/forgot-password', function () { return view('base'); });
Route::get('/reset-password/{token}', function () { return view('base'); });


Route::get('/dashboard', function () { return view('base'); });
Route::get('/dashboard/accounts', function () { return view('base'); });
Route::get('/dashboard/inventory-items', function () { return view('base'); });
Route::get('/dashboard/branches', function () { return view('base'); });
