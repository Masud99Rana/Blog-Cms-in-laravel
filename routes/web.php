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

Route::get('/author/{author}',[
	'uses'=> 'BLogController@author',
	'as' =>'author.post'
]);

Route::get('/tag/{tag}',[
	'uses'=> 'BLogController@tag',
	'as' =>'tag'
]);

Auth::routes();

Route::get('/home', 'Backend\HomeController@index')->name('home');

Route::get('/home', 'Backend\HomeController@index')->name('backend.blog.inbox');
Route::get('/edit-account', 'Backend\HomeController@edit');
Route::put('/edit-account', 'Backend\HomeController@update');

Route::put('/backend/blog/restore/{blog}', [
    'uses' => 'Backend\BlogController@restore',
    'as'   => 'backend.blog.restore'
]);
Route::delete('/backend/blog/force-destroy/{blog}', [
    'uses' => 'Backend\BlogController@forceDestroy',
    'as'   => 'backend.blog.force-destroy'
]);

Route::resource('/backend/blog', 'Backend\BlogController',[
	'as'=>'backend'
]);

Route::resource('/backend/categories', 'Backend\CategoriesController',[
	'as'=>'backend'
]);

Route::get('/backend/users/confirm/{users}', [
    'uses' => 'Backend\UsersController@confirm',
    'as' => 'backend.users.confirm'
]);
Route::resource('/backend/users', 'Backend\UsersController',[
	'as'=>'backend'
]);
