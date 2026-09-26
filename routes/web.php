<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PlatformController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DownloadController;
use Illuminate\Support\Facades\Auth;


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

Route::get('/', [HomeController::class, 'index']);
Route::get('juegos', [HomeController::class, 'games']);
Route::get('plataformas', [HomeController::class, 'platforms']);
Route::get('categorias', [HomeController::class, 'categories']);
Route::get('regiones', [HomeController::class, 'regions']);
Route::get('plataforma/{id}/alfabeto', [GameController::class, 'alphabet'])->name('platform.alphabet');
Route::get('juegos/{id}', [GameController::class, 'details'])->name('games.show');

Route::get('/download/{game}', [DownloadController::class, 'show'])
    ->name('download.show');

Route::get('/download/{game}/redirect', [DownloadController::class, 'redirect'])
    ->name('download.redirect');
Route::get('/download/{game}/link/{link}', [DownloadController::class, 'downloadLink'])
    ->name('download.link');

Auth::routes();
Route::get('login/{provider}', [LoginController::class, 'redirectToProvider']);
Route::get('{provider}/callback', [LoginController::class,'handleProviderCallback']);
Route::post('contacto', [HomeController::class, 'SendEmailContact']);

Route::get('noticia/{slug}', [HomeController::class,'news']);


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'noCache']], function() {
    Route::get('/', [DashboardController::class, 'index']);

    //perfil
    Route::view('perfil/editar','admin.editar-perfil');
    Route::put('perfil/editar', [ProfileController::class, 'update']);

    //Password
    Route::view('perfil/cambiar-contrasena', 'admin.cambiar-contrasena');
    Route::post('perfil/cambiar-contrasena', [PasswordController::class, 'update']);

    // usuarios
    Route::get('usuarios', [UserController::class, 'index']);
    Route::get('agregar-usuario', [UserController::class, 'create']);
    Route::post('usuarios/crear', [UserController::class, 'save']);
    Route::get('usuarios/{id}/editar',[UserController::class, 'edit']);
    Route::put('usuarios/{id}/actualizar',[UserController::class, 'update']);
    Route::delete('usuarios/eliminar/{id}',[UserController::class, 'destroy']);

    //permisos
    Route::get('permisos', [PermissionController::class, 'index']);
    Route::view('agregar-permisos', 'admin.permisos.crear');
    Route::post('permiso/crear', [PermissionController::class, 'save']);
    Route::get('permiso/{id}/editar', [PermissionController::class, 'edit']);
    Route::put('permiso/{id}/actualizar', [PermissionController::class, 'update']);
    Route::delete('permiso/eliminar/{id}', [PermissionController::class, 'delete']);

    //roles
    Route::get('roles', [RoleController::class, 'index']);
    Route::get('agregar-roles', [RoleController::class, 'create']);
    Route::post('roles/crear', [RoleController::class, 'save']);
    Route::get('roles/{id}/editar', [RoleController::class, 'edit']);
    Route::put('roles/{id}/actualizar', [RoleController::class, 'update']);
    Route::delete('roles/eliminar/{id}', [RoleController::class, 'delete']);

    //Usuarios
    Route::get('usuarios', [UserController::class, 'index']);

    //Password
    Route::view('cambiar-contrasena', 'principal.cambiar-contrasena');
    Route::post('cambiar-contrasena', 'Auth\PasswordController@update');
    
    Route::resource('plataformas', PlatformController::class);
    Route::resource('juegos', GameController::class);
    Route::resource('regiones', RegionController::class);
    Route::resource('categorias', CategoryController::class);

});