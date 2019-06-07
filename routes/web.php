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
	Route::any('/acceso', 'UserController@actionAcceso');
	Route::any('/accesobienvenido/{idempresa}/{idcargo}', 'UserController@actionAccesoBienvenido');
	
}); 

Route::get('/cerrarsession', 'UserController@actionCerrarSesion');
Route::get('/cambiarperfil', 'UserController@actionCambiarPerfil');


Route::group(['middleware' => ['authaw']], function () {


	Route::get('/bienvenido', 'UserController@actionBienvenido');

	Route::any('/gestion-de-usuarios/{idopcion}', 'UserController@actionListarUsuarios');
	Route::any('/agregar-usuario/{idopcion}', 'UserController@actionAgregarUsuario');
	Route::any('/modificar-usuario/{idopcion}/{idusuario}', 'UserController@actionModificarUsuario');
	Route::any('/ajax-activar-perfiles', 'UserController@actionAjaxActivarPerfiles');

	Route::any('/gestion-de-roles/{idopcion}', 'UserController@actionListarRoles');
	Route::any('/agregar-rol/{idopcion}', 'UserController@actionAgregarRol');
	Route::any('/modificar-rol/{idopcion}/{idrol}', 'UserController@actionModificarRol');

	Route::any('/gestion-de-permisos/{idopcion}', 'UserController@actionListarPermisos');
	Route::any('/ajax-listado-de-opciones', 'UserController@actionAjaxListarOpciones');
	Route::any('/ajax-activar-permisos', 'UserController@actionAjaxActivarPermisos');

	Route::any('/gestion-de-precio-producto/{idopcion}', 'ProductoController@actionPrecioProducto');
	Route::any('/ajax-guardar-precio-producto', 'ProductoController@actionAjaxGuardarPrecioProducto');

	Route::get('/gestion-de-regla-del-producto/{idopcion}', 'AsignarReglaController@actionListarClienteRegla');
	Route::any('/ajax-modal-detalle', 'AsignarReglaController@actionAjaxModalDetalle');
	Route::any('/ajax-detalle-regla', 'AsignarReglaController@actionAjaxDetalleRegla');	
	Route::any('/ajax-agregar-regla', 'AsignarReglaController@actionAjaxAgregarRegla');
	Route::any('/ajax-actualizar-lista-regla', 'AsignarReglaController@actionAjaxActualizarListaRegla');
	Route::any('/ajax-actualizar-modal-regla', 'AsignarReglaController@actionAjaxActualizarModalRegla');
	Route::any('/ajax-eliminar-regla', 'AsignarReglaController@actionAjaxEliminarRegla');

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

	Route::any('/gestion-de-orden-de-pedido/{idopcion}', 'OrdenPedidoController@actionListarPedido');
	Route::any('/agregar-orden-pedido/{idopcion}', 'OrdenPedidoController@actionAgregarOrdenPedido');








   	Route::get('buscarcliente', function (Illuminate\Http\Request  $request) {
        $term = $request->term ?: '';
        $tags = App\WEBListaCliente::where('NOM_EMPR', 'like', '%'.$term.'%')
				->where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
				->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
				->take(100)
        		->pluck('NOM_EMPR', 'NOM_EMPR');
        $valid_tags = [];
        foreach ($tags as $id => $tag) {
            $valid_tags[] = ['id' => $id, 'text' => $tag];
        }
        return \Response::json($valid_tags);
    });


   	Route::get('buscarproducto', function (Illuminate\Http\Request  $request) {
        $term = $request->term ?: '';
        $tags = App\WEBPrecioProducto::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
										//->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
										//->where('centro_id','=',Session::get('centros')->COD_CENTRO)
										->take(100)
										->pluck('NOM_PRODUCTO','producto_id');

        $valid_tags = [];
        foreach ($tags as $id => $tag) {
            $valid_tags[] = ['id' => $id, 'text' => $tag];
        }
        return \Response::json($valid_tags);
    });


});

	Route::any('/pruebas', 'UserController@pruebas');