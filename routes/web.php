<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
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
    return redirect()->route('usuario.bienvenida');
});

Route::prefix('/usuario')->group(function (){
    Route::get('/bienvenida',[UsuarioController::class,'bienvenida'])->name('usuario.bienvenida');
    Route::get('/login',[UsuarioController::class,'login'])->name('usuario.login');
    Route::get('/registro',[UsuarioController::class,'registro'])->name('usuario.registro');
    Route::post('/registro',[UsuarioController::class,'registroForm'])->name('usuario.registro.form');
    Route::get('/menu',[UsuarioController::class,'menu'])->name('usuario.menu');
    Route::get('/nombre/{v}', [UsuarioController::class,'crear']);
    Route::get('/crear',[UsuarioController::class,'crear']);
});



