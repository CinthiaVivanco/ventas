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

class AsignarReglaController extends Controller
{

	public function actionListarClienteRegla($idopcion,Request $request)
	{


		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
	    $cliente 			= $request['cliente_select'];
	    $producto_select 	= $request['producto_select'];
	    $respuestvacio 		= $this->funciones->respuestavacio($cliente,$producto_select);
	    $paginacion 		= 10;

	    // ingresa cuando no hay filtro
	    if($respuestvacio){

	    	// lista clientes
			$arrayidclientes 				= 	$this->funciones->array_id_clientes_top(100);

		    $listacliente 					= 	WEBListaCliente::name($cliente)
		    									->whereIn('id',$arrayidclientes)
		    									->orderBy('NOM_EMPR', 'asc')
						    					->where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
						    					//->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
		    									->paginate($paginacion);

	    	// lista productos
	    	$listadeproductos 				= 	$this->funciones->lista_productos_precio();
		    //combo clientes
	    	$combolistaclientes 			= 	$this->funciones->combo_nombres_lista_clientes();
		    //combo productos
	    	$combolistaproductos 			= 	$this->funciones->combo_nombres_lista_productos();



	    }else{ // ingresa cuando si hay filtro


		    $listacliente 					= 	WEBListaCliente::name($cliente)
						    					->where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
						    					//->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
												->orderBy('NOM_EMPR', 'asc')
												->paginate($paginacion);
	    	// lista productos
	    	$listadeproductos 				= 	$this->funciones->lista_productos_precio_buscar($producto_select);

		    //combo clientes
	    	$combolistaclientes 			= 	array($cliente => $cliente);
		    //combo productos
		    if($producto_select!=''){
	    		$combolistaproductos 		= 	array($producto_select => $this->funciones->nombre_producto_seleccionado($producto_select));		    	
		    }else{
		    	$combolistaproductos 		= 	$this->funciones->combo_nombres_lista_productos();
		    }


	    }

	    //combo tipo documento
		$combotipodocumentoxclientes 		= 	$this->funciones->combotipodocumentoxclientes();

	    //array de todos las reglas asignado a un producto segun el cliente
		$listareglaproductoclientes 		= 	WEBReglaProductoCliente::join('WEB.reglas', 'WEB.reglas.id', '=', 'WEB.reglaproductoclientes.regla_id')
												->select('WEB.reglaproductoclientes.id','producto_id','cliente_id','contrato_id','regla_id','nombre')
												->where('WEB.reglaproductoclientes.activo','=',1)
												->get();


		// capturar request en la vista = {{ Request::query('cliente_select') }}

		return View::make('regla/asignarregla',
						 [
						 	'listacliente' 				 	=> $listacliente,
						 	'listadeproductos' 				=> $listadeproductos,
						 	'listareglaproductoclientes' 	=> $listareglaproductoclientes,
						 	'combotipodocumentoxclientes' 	=> $combotipodocumentoxclientes,
						 	'combolistaclientes' 			=> $combolistaclientes,
						 	'combolistaproductos' 			=> $combolistaproductos,
						 	'idopcion' 					 	=> $idopcion,
						 ]);

	}


	public function actionAjaxActualizarListaRegla(Request $request)
	{

	    $producto_id 			= 	$request['producto_id'];
	    $cliente_id 			= 	$request['cliente_id'];
	    $contrato_id 			= 	$request['contrato_id'];
	    $tipo 					= 	$request['tipo'];
	    $color 					= 	$request['color'];
	    //array de todos las reglas asignado a un producto segun el cliente
		$listareglaproductoclientes 		= 	WEBReglaProductoCliente::join('WEB.reglas', 'WEB.reglas.id', '=', 'WEB.reglaproductoclientes.regla_id')
												->select('WEB.reglaproductoclientes.id','producto_id','cliente_id','contrato_id','regla_id','nombre')
												->where('WEB.reglaproductoclientes.activo','=',1)
												->get();


		return View::make('regla/listado/ajax/etiquetas',
						 [
						 	'cliente_id' 					=> $cliente_id,
						 	'producto_id'	 				=> $producto_id,
						 	'contrato_id'	 				=> $contrato_id,
						 	'tipo'	 						=> $tipo,
						 	'color'	 						=> $color,
						 	'listareglaproductoclientes'	=> $listareglaproductoclientes,
						 ]);
	}


	public function actionAjaxActualizarModalRegla(Request $request)
	{

	    $producto_id 			= 	$request['producto_id'];
	    $cliente_id 			= 	$request['cliente_id'];
	    $contrato_id 			= 	$request['contrato_id'];
	    $tipo 					= 	$request['tipo'];
	    $color 					= 	$request['color'];

		$listareglas 			= 	$this->funciones->reglas_actualizar_modal($producto_id,$cliente_id,$contrato_id,$tipo);

		return View::make('regla/modal/ajax/etiquetas',
						 [
						 	'listareglas' 					=> $listareglas,
						 	'color'	 						=> $color,
						 ]);
	}





	public function actionAjaxModalDetalle(Request $request)
	{


	    $producto_id 			= 	$request['producto_id'];
	    $cliente_id 			= 	$request['cliente_id'];
	    $contrato_id 			= 	$request['contrato_id'];
	    $nombre 				= 	$request['nombre'];
	    $tipo 					= 	$request['tipo'];
	    $nombreselect 			= 	$request['nombreselect'];
	    $prefijo 				= 	$request['prefijo'];
	    $color 					= 	$request['color'];

		$cliente 				= 	WEBListaCliente::where('id','=',$cliente_id)->where('COD_CONTRATO','=',$contrato_id)->first();
		$producto 				= 	$this->funciones->producto_buscar($producto_id);
		$listareglas 			= 	$this->funciones->reglas_actualizar_modal($producto_id,$cliente_id,$contrato_id,$tipo);
    	$comboreglas 			= 	$this->funciones->combo_activas_regla_tipo($tipo,$nombreselect);


		return View::make('regla/modal/ajax/detalle',
						 [
						 	'cliente' 				=> $cliente,
						 	'contrato_id' 			=> $contrato_id,
						 	'producto'	 			=> $producto,
						 	'listareglas'	 		=> $listareglas,
						 	'comboreglas'	 		=> $comboreglas,
						 	'nombre'	 			=> $nombre,
						 	'tipo'	 				=> $tipo,
						 	'nombreselect'	 		=> $nombreselect,
						 	'prefijo'	 			=> $prefijo,
						 	'color'	 				=> $color,
						 ]);
	}





	public function actionAjaxDetalleRegla(Request $request)
	{

	    $producto_id 			= 	$request['producto_id'];
	    $cliente_id 			= 	$request['cliente_id'];
	    $regla_id 				= 	$request['regla_id'];

		$regla 					= 	$this->funciones->regla_buscar($regla_id);
		$producto 				= 	$this->funciones->producto_buscar($producto_id);
		$cliente 				= 	$this->funciones->cliente_buscar($cliente_id);
		$fechavacia  			= 	$this->fechavacia;

		$funcion 				= 	$this;	

		return View::make('regla/popover/ajax/detalleregla',
						 [
						 	'cliente' 				=> $cliente,
						 	'producto'	 			=> $producto,
						 	'regla'	 				=> $regla,
						 	'fechavacia'	 		=> $fechavacia,
						 	'funcion'	 			=> $funcion,
						 ]);

	}


	public function actionAjaxAgregarRegla(Request $request)
	{


	    $producto_id 				= 	$request['producto_id'];
	    $cliente_id 				= 	$request['cliente_id'];
	    $contrato_id 				= 	$request['contrato_id'];
	    $regla_id 					= 	$request['regla_id'];
	    $tipo 						= 	$request['tipo'];

		$idreglaproductocliente 	= 	$this->funciones->getCreateIdMaestra('WEB.reglaproductoclientes');
		$mensaje 					=  	'Regla asignada con exito';


		$response 						= 	$this->funciones->precio_regla_calculo_menor_cero($producto_id,$cliente_id,$mensaje,$tipo,$regla_id);
		if($response[0]['error']){echo json_encode($response); exit();}


		$response 						= 	$this->funciones->tiene_regla_activa($producto_id,$cliente_id,$contrato_id,$mensaje,$tipo);
		if($response[0]['error']){echo json_encode($response); exit();}

		$cabecera            	 	=	new WEBReglaProductoCliente;
		$cabecera->id 	     	 	=  	$idreglaproductocliente;
		$cabecera->producto_id 	    =  	$producto_id;
		$cabecera->regla_id 	    =  	$regla_id;
		$cabecera->cliente_id 	    =  	$cliente_id;
		$cabecera->contrato_id 	    =  	$contrato_id;
		$cabecera->fecha_crea 	    =  	$this->fechaactual;
		$cabecera->usuario_crea 	=  	Session::get('usuario')->id;
		$cabecera->save();

		echo json_encode($response);
	}


	public function actionAjaxEliminarRegla(Request $request)
	{

	    $idreglaproductocliente 	= 	$request['idreglaproductocliente'];
		$mensaje 					=  	'Regla eliminada con exito';
		$error						=   false;

		$cabecera            	 	=	WEBReglaProductoCliente::find($idreglaproductocliente);			
		$cabecera->activo 	 	 	=  	0;			 
		$cabecera->save();


		$response[] = array(
			'error'           		=> $error,
			'mensaje'      			=> $mensaje
		);

		echo json_encode($response);
	}






}
