<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\WEBListaCliente,App\STDTipoDocumento,App\WEBReglaProductoCliente,App\WEBPedido,App\WEBDetallePedido;
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

	    $listapedidos		= 		WEBPedido::where('activo','=',1)
	    							->where('usuario_crea','=',Session::get('usuario')->id)
	    							->orderBy('fecha_venta', 'desc')
	    							->get();

		return View::make('pedido/listapedido',
						 [
						 	'idopcion' 		=> $idopcion,
						 	'listapedidos' 	=> $listapedidos,
						 ]);

	}


	public function actionAgregarOrdenPedido($idopcion ,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

		if($_POST)
		{

			try{

				DB::beginTransaction();

				$productos 					= 	$request['productos'];

				$total 						=   $this->funciones->calcular_cabecera_total($productos);
				$codigo 					= 	$this->funciones->generar_codigo('WEB.pedidos',8);
				$idpedido 					= 	$this->funciones->getCreateIdMaestra('WEB.pedidos');
				$cuenta_id 					= 	$this->funciones->desencriptar_id($request['cuenta'],10);
				$cliente_id 				= 	$this->funciones->desencriptar_id($request['cliente'],10);


				//PEDIDO
				$cabecera            	 	=	new WEBPedido;
				$cabecera->id 	     	 	=  	$idpedido;
				$cabecera->codigo 	    	=  	$codigo;
				$cabecera->igv 	    		=  	$this->funciones->calculo_igv($total);
				$cabecera->subtotal 	    =  	$this->funciones->calculo_subtotal($total);
				$cabecera->total 	    	=  	$total;
				$cabecera->estado 	    	=  	'EM';
				$cabecera->cuenta_id 	    =  	$cuenta_id; 
				$cabecera->cliente_id 	    =  	$cliente_id;
				$cabecera->empresa_id 		=   Session::get('empresas')->COD_EMPR;
				$cabecera->centro_id 		=   Session::get('centros')->COD_CENTRO;
				$cabecera->fecha_venta 	 	=   $this->fechaactual;
				$cabecera->fecha_crea 	 	=   $this->fechaactual;
				$cabecera->usuario_crea 	=   Session::get('usuario')->id;
				$cabecera->save();

				//DETALLE PEDIDO

				$productos 					= 	json_decode($productos, true);

				foreach($productos as $obj){

					$iddetallepedido 			= 	$this->funciones->getCreateIdMaestra('WEB.detallepedidos');
					$precio_producto 			=  	(float)$obj['precio_producto'];
					$cantidad_producto 			=  	(float)$obj['cantidad_producto'];
					$total_producto 			= 	$precio_producto*$cantidad_producto;
					$producto_id 				= 	$this->funciones->desencriptar_id($obj['prefijo_producto'].'-'.$obj['id_producto'],13);

					$cabecera            	 	=	new WEBDetallePedido;
					$cabecera->id 	     	 	=  	$iddetallepedido;
					$cabecera->precio 	    	=  	$precio_producto;
					$cabecera->cantidad 	    =  	$cantidad_producto;
					$cabecera->igv 	    		=  	$this->funciones->calculo_igv($total_producto);
					$cabecera->subtotal 	    =  	$this->funciones->calculo_subtotal($total_producto);
					$cabecera->total 	    	=  	$total_producto;
					$cabecera->pedido_id 	    =  	$idpedido;
					$cabecera->producto_id 	    =  	$producto_id;
					$cabecera->empresa_id 		=   Session::get('empresas')->COD_EMPR;
					$cabecera->centro_id 		=   Session::get('centros')->COD_CENTRO;
					$cabecera->fecha_crea 	 	=   $this->fechaactual;
					$cabecera->usuario_crea 	=   Session::get('usuario')->id;
					$cabecera->save();
				}			

				DB::commit();
 				return Redirect::to('/gestion-de-orden-de-pedido/'.$idopcion)->with('bienhecho', 'Pedido '.$codigo.' registrado con exito');

			}catch(Exception $ex){
				DB::rollback();
				return Redirect::to('/gestion-de-orden-de-pedido/'.$idopcion)->with('errorbd', 'Ocurrio un error inesperado. Porfavor contacte con el administrador del sistema');	
			}

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
