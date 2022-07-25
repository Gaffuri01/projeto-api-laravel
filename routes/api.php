<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\AtividadeController;

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

Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'getAllUsers');
    Route::get('/user/{id}', 'getUser');
    Route::post('/user', 'createUser');
    Route::put('/user/{id}', 'updateUser');
    Route::delete('/user/{id}', 'deleteUser');
});

Route::controller(CursoController::class)->group(function () {
    Route::get('/cursos', 'getAllCursos');
    Route::get('/curso/{id}', 'getCurso');
    Route::post('/curso', 'createCurso');
    Route::put('/curso/{id}', 'updateCurso');
    Route::delete('/curso/{id}', 'deleteCurso');
});

Route::controller(AtividadeController::class)->group(function () {
    Route::get('/atividades', 'getAllAtividades');
    Route::get('/atividade/{id}', 'getAtividade');
    Route::get('/all_cursos_atividade/{id}', 'getAllCursosAtividade');
    Route::post('/atividade', 'createAtividade');
    Route::put('/atividade/{id}', 'updateAtividade');
    Route::delete('/atividade/{id}', 'deleteAtividade');
});

Route::get('/poke_api', [ApiController::class, 'getPokemon']);

// Route::get('/download_anexo/{id}', AnexoController::class, 'download');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     // Route::get('/user', function(){
//         // return UserAPI::get();
//     // });
//     return $request->user();
// });
