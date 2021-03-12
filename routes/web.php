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
    return redirect()->route('bienvenida');
});

Route::get('/bienvenida',[UsuarioController::class,'bienvenida'])->name('bienvenida');
Route::get('/login',[UsuarioController::class,'login'])->name('login');
Route::post('/login',[UsuarioController::class,'verificarCredenciales'])->name('login.form');
Route::get('/registro',[UsuarioController::class,'registro'])->name('registro');
Route::post('/registro',[UsuarioController::class,'registroForm'])->name('registro.form');

Route::get('/ok',function (){
    return view('test');
});
Route::prefix('/usuario')->middleware("VerificarUsuario")->group(function (){
    Route::get('/menu',[UsuarioController::class,'menu'])->name('usuario.menu');
    Route::get('/nombre/{v}', [UsuarioController::class,'crear']);
    Route::get('/crear',[UsuarioController::class,'saludo']);
});



