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

Route::group(['middleware'=>['guest']], function()
{
  Route::get('/','Auth\LoginController@showLoginForm');
  Route::get('/login','Auth\LoginController@showLoginForm');
  Route::post('/login','Auth\LoginController@login')->name('login');
});

Route::group(['middleware'=>['auth']], function()
{
  Route::post('/logout','Auth\LoginController@logout')->name('logout');
  // ->name : Asignar Alias de Ruta
  Route::get('/main', function () {
      return view('principal');
  })->name('main');

  Route::get('/empresa','EmpresaController@index');
  Route::post('/empresa/registrar','EmpresaController@store');
  Route::put('/empresa/actualizar','EmpresaController@update');
  Route::put('/empresa/desactivar','EmpresaController@deactivate');
  Route::put('/empresa/delete','EmpresaController@delete');
  Route::put('/empresa/activar','EmpresaController@activate');

  Route::get('/cliente','ClienteController@index');
  Route::post('/cliente/registrar','ClienteController@store');
  Route::put('/cliente/actualizar','ClienteController@update');
  Route::put('/cliente/desactivar','ClienteController@deactivate');
  Route::put('/cliente/delete','ClienteController@delete');
  Route::put('/cliente/activar','ClienteController@activate');
  Route::get('/cliente/selectEmpresa','ClienteController@selectEmpresa');

  Route::get('/producto','ProductoController@index');
  Route::post('/producto/registrar','ProductoController@store');
  Route::put('/producto/actualizar','ProductoController@update');
  Route::put('/producto/desactivar','ProductoController@deactivate');
  Route::put('/producto/delete','ProductoController@delete');
  Route::put('/producto/activar','ProductoController@activate');
  Route::get('/producto/selectCliente','ProductoController@selectCliente');
  Route::get('/producto/selectTipoProducto','ProductoController@selectTipo');
  Route::put('/producto/enviarAlertExp','ProductoController@enviarAlertExp');
});


Route::get('/home', 'HomeController@index')->name('home');
