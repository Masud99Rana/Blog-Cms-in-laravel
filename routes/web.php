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

Route::get('/', [
	'uses'=> 'BLogController@index',
	'as' =>'blog'
]);

Route::get('/blog/{post}',[
	'uses'=> 'BLogController@show',
	'as' =>'blog.show'
]);

Route::get('/category/{category}',[
	'uses'=> 'BLogController@category',
	'as' =>'category'
]);
