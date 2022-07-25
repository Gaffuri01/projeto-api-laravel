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

Route::post('users', 'ApiController@createUser');

// Route::get('/user', function(){
//     return UserAPI::get();
// });

// $router->group(['prefix' => '/api'], function () use ($router) {
//     // $router->get('/livros', 'LivrosController@index');
//     $router->get('/user', UserController::getAllUser($_REQUEST));
// });