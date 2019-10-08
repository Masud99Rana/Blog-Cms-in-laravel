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

Auth::routes();

Route::get('/home', 'Backend\HomeController@index')->name('home');

Route::get('/home', 'Backend\HomeController@index')->name('backend.blog.inbox');

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
