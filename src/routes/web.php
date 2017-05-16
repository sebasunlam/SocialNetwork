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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/*Parametricos*/
Route::get('sexo/all','SexoController@all')->name('sexo.all');
Route::get('departamento/{provincia_id}/provincia','DepartamentoController@byProvincia')->name('departamento.byProvincia');
Route::get('localidad/{departamento_id}/departamento','LocalidadController@byDepartamento')->name('departamento.byDepartamento');


/*Profile*/
Route::get('profile', 'ProfileController@index')->name('profile');
Route::get('profile/create','ProfileController@create')->name('profile.create');
Route::post('profile/store','ProfileController@store')->name('profile.store');
Route::get('profile/edit','ProfileController@edit')->name('profile.edit');
Route::patch('profile/update','ProfileController@update')->name('profile.update');
Route::get('profile/show','ProfileController@show')->name('profile.show');

/*Feed*/
Route::get('feed','FeedControllerq@index')->name('feed');

