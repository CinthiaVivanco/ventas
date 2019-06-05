<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\WEBListaCliente,App\STDTipoDocumento,App\WEBReglaProductoCliente;
use View;
use Session;

class OrdenPedidoController extends Controller
{

	public function actionListarPedido($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

		return View::make('pedido/listapedido',
						 [
						 	'idopcion' => $idopcion,
						 ]);
	}


	public function actionAgregarOrdenPedido($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

		if($_POST)
		{

			dd("guardar");

		}else{


		    $listaclientes 		= 	WEBListaCliente::where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
						    		->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
									->orderBy('NOM_EMPR', 'asc')
									->get();
		
		    $listaproductos 	= 	DB::table('WEB.LISTAPRODUCTOSAVENDER')
		    					 	->orderBy('NOM_PRODUCTO', 'asc')->get();

			return View::make('pedido/ordenpedido',
						[				
						  	'idopcion'  			=> $idopcion,
						  	'listaclientes'  		=> $listaclientes,
						  	'listaproductos'  		=> $listaproductos,
						]);
		}
	}


}
