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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/postagens', ['uses'=>'PostController@index', 'as'=>'post.index']);
Route::get('/postagens/add', ['uses'=>'PostController@add', 'as'=>'post.add']);
Route::post('/postagens/save', ['uses'=>'PostController@save', 'as'=>'post.save']);
Route::get('/postagens/edit/{id}', ['uses'=>'PostController@edit', 'as'=>'post.edit']);
Route::get('/postagens/detail/{id}/{success?}', ['uses'=>'PostController@detail', 'as'=>'post.detail']);
Route::post('/postagens/update/{id}', ['uses'=>'PostController@update', 'as'=>'post.update']);
Route::get('/postagens/delete/{id}', ['uses'=>'PostController@delete', 'as'=>'post.delete']);
Route::put('/postagens/search', ['uses'=>'PostController@search', 'as'=>'post.search']);


Route::post('/comentarios/save', ['uses'=>'CommentController@save', 'as'=>'comment.save']);


Route::get('/usuarios', ['uses'=>'UserController@index', 'as'=>'user.index'])->middleware('admin');
Route::get('/usuarios/add', ['uses'=>'UserController@add', 'as'=>'user.add'])->middleware('admin');
Route::post('/usuarios/save', ['uses'=>'UserController@save', 'as'=>'user.save'])->middleware('admin');
Route::get('/usuarios/edit/{id}', ['uses'=>'UserController@edit', 'as'=>'user.edit'])->middleware('admin');
Route::post('/usuarios/update/{id}', ['uses'=>'UserController@update', 'as'=>'user.update'])->middleware('admin');
Route::get('/usuarios/delete/{id}', ['uses'=>'UserController@delete', 'as'=>'user.delete'])->middleware('admin');
Route::put('/usuarios/search', ['uses'=>'UserController@search', 'as'=>'user.search'])->middleware('admin');