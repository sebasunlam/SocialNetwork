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
Route::get("login/{provider}",'Auth\LoginController@redirectProvider')->name('redirectProvider');
Route::get("login/{provider}/callback",'Auth\LoginController@handleCallback')->name('handleCallback');

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
Route::post('profile/unfollow','ProfileController@unfollow')->name('profile.unfollow')->middleware('auth');

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
Route::get('mascota/multipleSearch/{text}','MascotaController@multipleSearch')->name('mascota.multipleSearch');
Route::get('mascota/all','MascotaController@all')->name('mascota.all');
Route::get('mascota/{mascotaId}/tipo','MascotaController@getTipoId')->name('mascota.tipo');
Route::get('mascota/pdf/{id}','MascotaController@getPdf')->name('mascota.pdf');


/*Ranking*/
Route::get('ranking/{tipo}','RankingController@rannkingMascotaTipo')->name('ranking.tipo')->middleware('auth');
Route::get('ranking','RankingController@rannkingMascota')->name('ranking.todos')->middleware('auth');

/*Citas*/

Route::post("citas/buscando/{id}","CitasController@buscandoCita")->name("citas.buscando")->middleware("auth");
Route::post("citas/dejardebuscar/{id}","CitasController@dejarDeBuscar")->name("citas.dejardebuscar")->middleware("auth");
Route::post("citas/solicitar","CitasController@pedirCita")->name("citas.solicitar")->middleware("auth");
Route::get("citas/buscar","CitasController@getBusquedaView")->name("citas.buscar")->middleware("auth");
Route::post("citas/find","CitasController@busqueda")->name("citas.find")->middleware("auth");
Route::get("citas/notificar","CitasController@notificacionCitas")->name("citas.notificaciones")->middleware("auth");
Route::get("citas/tiene","CitasController@hasCita")->name("citas.tiene")->middleware("auth");
Route::get("citas/lista","CitasController@listadoCitas")->name("citas.lista")->middleware("auth");
Route::post("citas/acepta","CitasController@aceptarCita")->name("citas.acepta")->middleware("auth");

/*Perdido*/
Route::post("perdido/marcar/{id}","PerdidoController@marcarPerdido")->name("perdido.marcar")->middleware("auth");
Route::post("perdido/descmarcar/{id}","PerdidoController@desmarcarPerdido")->name("perdido.desmarcar")->middleware("auth");
Route::post("perdido/acepta/{encontradoId}","PerdidoController@acepta")->name("perdido.acepta")->middleware("auth");
Route::get("perdido/tiene","PerdidoController@hasEncontrados")->name("perdido.tiene")->middleware("auth");
Route::get("perdido/encontrados","PerdidoController@getEncontrados")->name("perdido.encontrados")->middleware("auth");
Route::post("perdido/encontrado","PerdidoController@encontrado")->name("perdido.encontrado");
Route::get("perdido/all","PerdidoController@getPerdidos")->name("perdido.all");


