<?php

use App\Models\{
    Perfil
};

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
//
//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/','HomeController@index');
Auth::routes();

/*Parametricos*/
Route::get('sexo/all','SexoController@all')->name('sexo.all')->middleware('auth');
Route::get('departamento/{provincia_id}/provincia','DepartamentoController@byProvincia')->name('departamento.byProvincia')->middleware('auth');
Route::get('localidad/{departamento_id}/departamento','LocalidadController@byDepartamento')->name('localidad.byDepartamento')->middleware('auth');
Route::get('raza/{tipo_id}/tipo','RazaController@byTipo')->name('raza.byTipo')->middleware('auth');


/*Profile*/
Route::get('profile', 'ProfileController@index')->name('profile')->middleware('auth');
Route::get('profile/create','ProfileController@create')->name('profile.create')->middleware('auth');
Route::post('profile/store','ProfileController@store')->name('profile.store')->middleware('auth');
Route::get('profile/edit','ProfileController@edit')->name('profile.edit')->middleware('auth');
Route::patch('profile/update','ProfileController@update')->name('profile.update')->middleware('auth');
Route::get('profile/show/{id}','ProfileController@show')->name('profile.show');
Route::post('profile/comment','ProfileController@comment')->name('profile.comment')->middleware('auth');
Route::post('profile/follow','ProfileController@follow')->name('profile.follow')->middleware('auth');

/*Feed*/
Route::get('feed','FeedController@index')->name('feed')->middleware('auth');


/*Mascotas*/

Route::get('mascota','MascotaController@index')->name('mascota')->middleware('auth');
Route::get('mascota/create','MascotaController@create')->name('mascota.create')->middleware('auth');
Route::post('mascota/store','MascotaController@store')->name('mascota.store')->middleware('auth');
Route::get('mascota/edit/{id}','MascotaController@edit')->name('mascota.edit')->middleware('auth');
Route::patch('mascota/update/{id}','MascotaController@update')->name('mascota.update')->middleware('auth');
Route::get('mascota/show/{id}','MascotaController@show')->name('mascota.show');
Route::post('mascota/post/{id}','MascotaController@post')->name('mascota.post');

