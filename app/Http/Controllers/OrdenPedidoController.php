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
use App\Biblioteca\Osiris;
use PDO;

class OrdenPedidoController extends Controller
{


	public function actionEnviarOsirisRechazar($idopcion,Request $request)
	{

		if($_POST)
		{

			$msjarray  			= array();
			$respuesta 			= json_decode($request['pedidorechazar'], true);
			$finicio 			= $request['fechainiciorechazar'];
			$fechafin 			= $request['fechafinrechazar'];
	        $conts   			= 0;
	        $contw				= 0;
			$contd				= 0;
		

			foreach($respuesta as $obj){

				$pedido_id 					= 	$this->funciones->desencriptar_id('1CIX-'.$obj['id'],8);
				$pedido 					=   WEBPedido::where('id','=',$pedido_id)->first();


			    if($pedido->estado == 'EM'){ 

				    $pedido->estado 		= 	'RE';
					$pedido->fecha_mod 	 	=   $this->fechaactual;
					$pedido->usuario_mod 	=   Session::get('usuario')->id;
   					$pedido->save();

			    	$msjarray[] 			= 	array(	"data_0" => $pedido->codigo, 
			    									"data_1" => 'pedido rechazado', 
			    									"tipo" => 'S');
			    	$conts 					= 	$conts + 1;

			    }else{


					/**** ERROR DE PROGRMACION O SINTAXIS ****/
					$msjarray[] = array("data_0" => $pedido->codigo, 
										"data_1" => 'este pedido esta aceptado', 
										"tipo" => 'D');
					$contd 		= 	$contd + 1;


			    }

			}


			/************** MENSAJES DEL DETALLE PEDIDO  ******************/
	    	$msjarray[] = array("data_0" => $conts, 
	    						"data_1" => 'pedidos rechazados', 
	    						"tipo" => 'TS');

	    	$msjarray[] = array("data_0" => $contw, 
	    						"data_1" => 'pedidos', 
	    						"tipo" => 'TW');	 

	    	$msjarray[] = array("data_0" => $contd, 
	    						"data_1" => 'pedidos errados', 
	    						"tipo" => 'TD');

			$msjarray[] = array("data_0" => $finicio, 
								"data_1" => $fechafin, 
								"tipo" => 'FE');

			$msjjson = json_encode($msjarray);

			return Redirect::to('/gestion-de-orden-de-pedido/'.$idopcion)->with('xmlmsj', $msjjson);

		
		}

	}



	public function actionEnviarOsiris($idopcion,Request $request)
	{

		if($_POST)
		{

			$msjarray  			= array();
			$respuesta 			= json_decode($request['pedido'], true);
			$finicio 			= $request['fechainicio'];
			$fechafin 			= $request['fechafin'];
	        $conts   			= 0;
	        $contw				= 0;
			$contd				= 0;
		

			foreach($respuesta as $obj){

				$pedido_id 					= 	$this->funciones->desencriptar_id('1CIX-'.$obj['id'],8);
				$pedido 					=   WEBPedido::where('id','=',$pedido_id)->first();
				$osiris 					= 	new Osiris();
				$respuesta 					=  	$osiris->guardar_orden_pedido($pedido);

			    if($respuesta){ 

				    $pedido->estado 		= 	'AC';
				    $pedido->orden_id 		= 	$osiris->orden_id;
					$pedido->fecha_mod 	 	=   $this->fechaactual;
					$pedido->usuario_mod 	=   Session::get('usuario')->id;
   					$pedido->save();

			    	$msjarray[] 			= 	array(	"data_0" => $pedido->codigo, 
			    									"data_1" => 'aceptado a osiris', 
			    									"tipo" => 'S');
			    	$conts 					= 	$conts + 1;

			    }else{


					/**** ERROR DE PROGRMACION O SINTAXIS ****/
					$msjarray[] = array("data_0" => $pedido->codigo, 
										"data_1" => $osiris->msjerror, 
										"tipo" => 'D');
					$contd 		= 	$contd + 1;


			    }

			}


			/************** MENSAJES DEL DETALLE PEDIDO  ******************/
	    	$msjarray[] = array("data_0" => $conts, 
	    						"data_1" => 'pedidos aceptados', 
	    						"tipo" => 'TS');

	    	$msjarray[] = array("data_0" => $contw, 
	    						"data_1" => 'pedidos rechazados', 
	    						"tipo" => 'TW');	 

	    	$msjarray[] = array("data_0" => $contd, 
	    						"data_1" => 'pedidos errados', 
	    						"tipo" => 'TD');

			$msjarray[] = array("data_0" => $finicio, 
								"data_1" => $fechafin, 
								"tipo" => 'FE');

			$msjjson = json_encode($msjarray);

			return Redirect::to('/gestion-de-orden-de-pedido/'.$idopcion)->with('xmlmsj', $msjjson);

		
		}

	}




	public function actionAjaxListarTomaPedido(Request $request)
	{

		$finicio 		=  date_format(date_create($request['finicio']), 'd-m-Y');
		$ffin 			=  date_format(date_create($request['ffin']), 'd-m-Y');

	    $listapedidos	= 	WEBPedido::where('activo','=',1)
		    				->where('fecha_venta','>=', $finicio)
		    				->where('fecha_venta','<=', $ffin)
	    					->orderBy('fecha_venta', 'desc')
	    					->get();
		return View::make('pedido/ajax/listatomapedido',
						 [
							 'listapedidos'   => $listapedidos,
							 'ajax'   		  => true
						 ]);

	}







	public function actionListarTomaPedido($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/




	    if (Session::get('xmlmsj')){

	    	$obj 				= json_decode(Session::get('xmlmsj'));
	    	$pfi 				= array_search('FE', array_column($obj, 'tipo'));
	    	$pff 				= array_search('FE', array_column($obj, 'tipo'));
            $fechainicio 		= $obj[$pfi]->data_0;
            $fechafin 			= $obj[$pff]->data_1;

	    }else{

		    $fechainicio  		= 	$this->inicio;
		    $fechafin  			= 	$this->fin;

	    }


	    $listapedidos		= 	WEBPedido::where('activo','=',1)
		    					->where('fecha_venta','>=', $fechainicio)
		    					->where('fecha_venta','<=', $fechafin)
	    						->orderBy('fecha_venta', 'desc')
	    						->get();

		return View::make('pedido/listatomapedido',
						 [
						 	'idopcion' 		=> $idopcion,
						 	'listapedidos' 	=> $listapedidos,
						 	'fechainicio' 	=> $fechainicio,
						 	'fechafin' 		=> $fechafin,
						 ]);

	}



	public function actionListarPedido($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/


		$tipocambio 		= 		DB::table('WEB.VIEWTIPOCAMBIO')
        							->where('FEC_CAMBIO','=',date('Y-m-d').' 00:00:00.000')
        							->orderBy('FEC_CAMBIO', 'desc')
        							->first();


       	dd($tipocambio);

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
				$direcion_entrega_id 		= 	$request['direccion_entrega'];


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
				$cabecera->direccion_entrega_id 	    =  	$direcion_entrega_id;
				$cabecera->empresa_id 		=   Session::get('empresas')->COD_EMPR;
				$cabecera->centro_id 		=   Session::get('centros')->COD_CENTRO;
				$cabecera->fecha_venta 	 	=   $this->fin;
				$cabecera->fecha_time_venta =   $this->fechaactual;
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
 				return Redirect::to('/gestion-de-toma-de-pedido/'.$idopcion)->with('bienhecho', 'Pedido '.$codigo.' registrado con exito');

			}catch(Exception $ex){
				DB::rollback();
				return Redirect::to('/gestion-de-toma-de-pedido/'.$idopcion)->with('errorbd', 'Ocurrio un error inesperado. Porfavor contacte con el administrador del sistema');	
			}

		}else{


		    $listaclientes 		= 	WEBListaCliente::where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
						    		//->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
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



	public function actionAjaxDireccioncliente(Request $request)
	{

		$data_icl 					=  	$request['data_icl']; //id_cliente
		$data_pcl 					=  	$request['data_pcl']; //prefijo_cliente
		$data_icu 					=  	$request['data_icu']; //id_contrato
		$data_pcu 					=  	$request['data_pcu']; //prefijo_contrato
		$data_ncl 					=  	$request['data_ncl']; //nombre_cliente
		$data_dcl 					=  	$request['data_dcl']; //documento_cliente
		$data_ccl 					=  	$request['data_ccl']; //cuenta_cliente

		$cliente_id 				= 	$this->funciones->desencriptar_id($data_pcl.'-'.$data_icl,10);

	    $direcciones 				= 	DB::table('WEB.LISTADIRECCION')
	    					 			->orderBy('IND_DIRECCION_FISCAL', 'desc')
	    					 			->where('COD_EMPR','=',$cliente_id)
	    					 			->pluck('NOM_DIRECCION','COD_DIRECCION')
	    					 			->toArray();
		$combodirecciones  			= 	array('' => "Seleccione dirección") + $direcciones;



		return View::make('pedido/ajax/direccion',
						 [
						 	'combodirecciones' 	=> $combodirecciones,
						 	'data_icl' 			=> $data_icl,
						 	'data_pcl' 			=> $data_pcl,
						 	'data_icu' 			=> $data_icu,
						 	'data_pcu' 			=> $data_pcu,
						 	'data_ncl' 			=> $data_ncl,
						 	'data_dcl' 			=> $data_dcl,
						 	'data_ccl' 			=> $data_ccl,
						 ]);


	}



}
