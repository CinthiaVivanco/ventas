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

/********************** USUARIOS *************************/

Route::group(['middleware' => ['guestaw']], function () {

	Route::any('/', 'UserController@actionLogin');
	Route::any('/login', 'UserController@actionLogin');

}); 

Route::get('/cerrarsession', 'UserController@actionCerrarSesion');

Route::group(['middleware' => ['authaw']], function () {

	Route::get('/bienvenido', 'UserController@actionBienvenido');

	Route::any('/gestion-de-usuarios/{idopcion}', 'UserController@actionListarUsuarios');
	Route::any('/agregar-usuario/{idopcion}', 'UserController@actionAgregarUsuario');
	Route::any('/modificar-usuario/{idopcion}/{idusuario}', 'UserController@actionModificarUsuario');

	Route::any('/gestion-de-roles/{idopcion}', 'UserController@actionListarRoles');
	Route::any('/agregar-rol/{idopcion}', 'UserController@actionAgregarRol');
	Route::any('/modificar-rol/{idopcion}/{idrol}', 'UserController@actionModificarRol');

	Route::any('/gestion-de-permisos/{idopcion}', 'UserController@actionListarPermisos');
	Route::any('/ajax-listado-de-opciones', 'UserController@actionAjaxListarOpciones');
	Route::any('/ajax-activar-permisos', 'UserController@actionAjaxActivarPermisos');

	Route::any('/gestion-de-precio-producto/{idopcion}', 'ProductoController@actionPrecioProducto');
	Route::any('/ajax-guardar-precio-producto', 'ProductoController@actionAjaxGuardarPrecioProducto');


	Route::any('/gestion-de-regla-de-negociacion/{idopcion}', 'ProductoController@actionListarReglaNegociacion');
	Route::any('/agregar-regla-negociacion/{idopcion}', 'ProductoController@actionAgregarNegociacion');
	Route::any('/modificar-regla-negociacion/{idopcion}/{idregla}', 'ProductoController@actionModificarNegociacion');


	Route::any('/gestion-de-regla-de-precio-producto/{idopcion}', 'ProductoController@actionListarReglaPrecio');
	Route::any('/agregar-regla-precio/{idopcion}', 'ProductoController@actionAgregarPrecio');
	Route::any('/modificar-regla-precio/{idopcion}/{idregla}', 'ProductoController@actionModificarPrecio');

	Route::any('/gestion-de-regla-de-cupon-producto/{idopcion}', 'ProductoController@actionListarReglaCupones');
	Route::any('/agregar-regla-cupon/{idopcion}', 'ProductoController@actionAgregarCupon');
	Route::any('/modificar-regla-cupon/{idopcion}/{idregla}', 'ProductoController@actionModificarCupon');

	Route::any('/ajax-generarcupon', 'ProductoController@actionAjaxGenerarCupon');


});

	Route::any('/pruebas', 'UserController@pruebas');