<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\CMPCategoria,App\WEBPrecioProducto,App\WEBPrecioProductoHistorial,App\WEBRegla;
use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;


class ProductoController extends Controller
{


	public function actionPrecioProducto($idopcion)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $departamentos 		= 	DB::table('CMP.CATEGORIA')
	    					 	->where('TXT_GRUPO','=','DEPARTAMENTO')
	    					 	->orderBy('NOM_CATEGORIA', 'asc')->get();


	    $productos 			= 	DB::table('WEB.LISTAPRODUCTOSAVENDER')
	    						->leftJoin('WEB.precioproductos', 'WEB.LISTAPRODUCTOSAVENDER.COD_PRODUCTO', '=', 'WEB.precioproductos.producto_id')
	    						//->where('WEB.LISTAPRODUCTOSAVENDER.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
	    					 	->orderBy('NOM_PRODUCTO', 'asc')->get();


		return View::make('catalogo/precioproducto',
						 [
						 	'departamentos' => $departamentos,
						 	'productos' 	=> $productos,
						 	'idopcion' 		=> $idopcion,
						 ]);

	}


	public function actionAjaxGuardarPrecioProducto(Request $request)
	{

		$precio 					=  	$request['precio'];
		$producto_id 				=  	$request['producto_id'];
		$producto_pre 				=  	$request['producto_pre'];
		$producto_id 				=  	$this->funciones->decodificarid($producto_id,$producto_pre);

		$precioproducto             =   WEBPrecioProducto::where('producto_id','=',$producto_id)->first();

		if(count($precioproducto)>0){

			/****** MODIFICAR PRECIO PRODUCTO **********/
			
			$cabecera            	 	=	WEBPrecioProducto::find($precioproducto->id);;
			$cabecera->precio 	     	=   $precio;
			$cabecera->fecha_mod 	 	=   $this->fechaactual;
			$cabecera->usuario_mod 		=   Session::get('usuario')->id;
			$cabecera->save();

			/****** AGREGAR PRECIO PRODUCTO HOSTORIAL **********/
			$idprecioproductohistorial 	=  	$this->funciones->getCreateIdMaestra('WEB.precioproductohistoriales');
			$cabecera            	 	=	new WEBPrecioProductoHistorial;
			$cabecera->id 	     	 	=   $idprecioproductohistorial;
			$cabecera->precio 	     	=   $precioproducto->precio;
			$cabecera->fecha_crea 	 	=   $this->fechaactual;
			$cabecera->usuario_crea 	=   $precioproducto->usuario_crea;
			$cabecera->precioproducto_id= 	$precioproducto->id;
			$cabecera->producto_id 	 	= 	$precioproducto->producto_id;
			$cabecera->empresa_id 		=   $precioproducto->empresa_id;
			$cabecera->centro_id 		=   $precioproducto->centro_id;
			$cabecera->save();

		}else{

			/****** AGREGAR PRECIO PRODUCTO **********/
			$idprecioproducto 			=  	$this->funciones->getCreateIdMaestra('WEB.precioproductos');
			$cabecera            	 	=	new WEBPrecioProducto;
			$cabecera->id 	     	 	=   $idprecioproducto;
			$cabecera->precio 	     	=   $precio;
			$cabecera->fecha_crea 	 	=   $this->fechaactual;
			$cabecera->usuario_crea 	=   Session::get('usuario')->id;
			$cabecera->producto_id 	 	= 	$producto_id;
			$cabecera->empresa_id 		=   Session::get('empresas')->COD_EMPR;
			$cabecera->centro_id 		=   Session::get('centros')->COD_CENTRO;
			$cabecera->save();

		}

		echo("Precio guardado con exito");

	}


	public function actionListarReglaNegociacion($idopcion)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $listanegociacion = WEBRegla::orderBy('fechafin', 'asc')
	    					->where('tiporegla','=','NEG')
	    					//->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
	    					//->where('centro_id','=',Session::get('centros')->COD_CENTRO)
	    					->get();

		$fechavacia  = $this->fechavacia;

		return View::make('regla/listanegociacion',
						 [
						 	'listanegociacion' 		=> $listanegociacion,
						 	'fechavacia'	 		=> $fechavacia,
						 	'idopcion' 				=> $idopcion,
						 ]);
	}


	public function actionAgregarNegociacion($idopcion,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}

	    /******************************************************/

		if($_POST)
		{

			$codigo 					= 	$this->funciones->generar_codigo('WEB.reglas',6);
			$idregla 					= 	$this->funciones->getCreateIdMaestra('WEB.reglas');

			$cabecera            	 	=	new WEBRegla;
			$cabecera->id 	     	 	=  	$idregla;
			$cabecera->codigo 	    	=  	$codigo;
			$cabecera->tiporegla 	    =  	'NEG';
			$cabecera->nombre 	     	=  	trim($request['nombre']);
			$cabecera->fechainicio 	    =  	trim($request['fechainicio']);
			$cabecera->fechafin 	    =  	trim($request['fechafin']);
			$cabecera->cantidadminima 	=  	trim($request['cantidadminima']);
			$cabecera->tipodescuento 	=  	'IMP';
			$cabecera->descuento 		=  	trim($request['descuento']);
			$cabecera->estado 			=  	trim($request['estado']);
			$cabecera->fecha_crea 	    =  	$this->fechaactual;
			$cabecera->usuario_crea 	=  	Session::get('usuario')->id;
			$cabecera->empresa_id 		=   Session::get('empresas')->COD_EMPR;
			$cabecera->centro_id 		=   Session::get('centros')->COD_CENTRO;
			$cabecera->save();
 

 			return Redirect::to('/gestion-de-regla-de-negociacion/'.$idopcion)->with('bienhecho', 'Negociación '.$request['nombre'].' registrado con exito');


		}else{

			$fechaactual = $this->fechaactualinput;
			$fechavacia  = $this->fechavacia;

			return View::make('regla/agregarnegociacion',
						[				
							'fechaactual'  		=> $fechaactual,
							'fechavacia'  		=> $fechavacia,	
						  	'idopcion'  		=> $idopcion,
						]);
		}
	}


	public function actionModificarNegociacion($idopcion,$idregla,Request $request)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Modificar');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
	    $idregla = $this->funciones->decodificarmaestra($idregla);

		if($_POST)
		{

			$cabecera            	 	=	WEBRegla::find($idregla);
			$cabecera->nombre 	     	=  	trim($request['nombre']);
			$cabecera->fechainicio 	    =  	trim($request['fechainicio']);
			$cabecera->fechafin 	    =  	trim($request['fechafin']);
			$cabecera->cantidadminima 	=  	trim($request['cantidadminima']);
			$cabecera->descuento 		=  	trim($request['descuento']);
			$cabecera->estado 			=  	trim($request['estado']);
			$cabecera->fecha_mod 	    =  	$this->fechaactual;
			$cabecera->usuario_mod 		=  	Session::get('usuario')->id;
			$cabecera->save();
 
 			return Redirect::to('/gestion-de-regla-de-negociacion/'.$idopcion)->with('bienhecho', 'Descuento '.$request['nombre'].' modificado con éxito');


		}else{


				$regla = WEBRegla::where('id', $idregla)->first();
				$fechavacia  = $this->fechavacia;
	
		        return View::make('regla/modificarnegociacion', 
		        				[
		        					'regla'  		=> $regla,
									'fechavacia'  	=> $fechavacia,
						  			'idopcion' 		=> $idopcion
		        				]);
		}
	}





	public function actionListarReglaPrecio($idopcion)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $listaprecio = 	WEBRegla::orderBy('fechafin', 'asc')
	    				->whereIn('tiporegla', ['POV', 'PNC'])
	    				//->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
	    				//->where('centro_id','=',Session::get('centros')->COD_CENTRO)
	    				->get();
		$fechavacia  = $this->fechavacia;

		return View::make('regla/listaprecios',
						 [
						 	'listaprecio' 		=> $listaprecio,
						 	'fechavacia'	 	=> $fechavacia,
						 	'idopcion' 			=> $idopcion,
						 ]);
	}


	public function actionAgregarPrecio($idopcion,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}

	    /******************************************************/

		if($_POST)
		{


			$codigo 					= 	$this->funciones->generar_codigo('WEB.reglas',6);
			$idregla 					= 	$this->funciones->getCreateIdMaestra('WEB.reglas');

			$documento 					=   trim($request['documento']);
			$cabecera            	 	=	new WEBRegla;
			$cabecera->id 	     	 	=  	$idregla;
			$cabecera->codigo 	    	=  	$codigo;
			$cabecera->tiporegla 	    =  	'P'.$documento;
			$cabecera->nombre 	     	=  	trim($request['nombre']);
			$cabecera->fechainicio 	    =  	trim($request['fechainicio']);
			$cabecera->fechafin 	    =  	trim($request['fechafin']);
			$cabecera->cantidadminima 	=  	trim($request['cantidadminima']);
			$cabecera->tipodescuento 	=  	trim($request['tipodescuento']);
			$cabecera->descuento 		=  	trim($request['descuento']);
			$cabecera->estado 			=  	trim($request['estado']);
			$cabecera->documento 		=  	trim($request['documento']);
			$cabecera->descuentoaumento =  	$request['descuentoaumento'];
			$cabecera->fecha_crea 	    =  	$this->fechaactual;
			$cabecera->usuario_crea 	=  	Session::get('usuario')->id;
			$cabecera->empresa_id 		=   Session::get('empresas')->COD_EMPR;
			$cabecera->centro_id 		=   Session::get('centros')->COD_CENTRO;
			$cabecera->save();
 

 			return Redirect::to('/gestion-de-regla-de-precio-producto/'.$idopcion)->with('bienhecho', 'Descuento '.$request['nombre'].' registrado con exito');


		}else{

			$fechaactual = $this->fechaactualinput;
			$fechavacia  = $this->fechavacia;

			return View::make('regla/agregarprecio',
						[				
							'fechaactual'  		=> $fechaactual,
							'fechavacia'  		=> $fechavacia,	
						  	'idopcion'  		=> $idopcion,
						]);
		}
	}


	public function actionModificarPrecio($idopcion,$idregla,Request $request)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Modificar');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
	    $idregla = $this->funciones->decodificarmaestra($idregla);

		if($_POST)
		{

			$cabecera            	 	=	WEBRegla::find($idregla);
			$cabecera->nombre 	     	=  	trim($request['nombre']);
			$cabecera->fechainicio 	    =  	trim($request['fechainicio']);
			$cabecera->fechafin 	    =  	trim($request['fechafin']);
			$cabecera->cantidadminima 	=  	trim($request['cantidadminima']);
			$cabecera->tipodescuento 	=  	trim($request['tipodescuento']);
			$cabecera->descuento 		=  	trim($request['descuento']);
			$cabecera->estado 			=  	trim($request['estado']);
			$cabecera->documento 		=  	trim($request['documento']);
			$cabecera->fecha_mod 	    =  	$this->fechaactual;
			$cabecera->usuario_mod 		=  	Session::get('usuario')->id;
			$cabecera->save();
 
 			return Redirect::to('/gestion-de-regla-de-precio-producto/'.$idopcion)->with('bienhecho', 'Descuento '.$request['nombre'].' modificado con éxito');


		}else{


				$regla = WEBRegla::where('id', $idregla)->first();
				$fechavacia  = $this->fechavacia;
	
		        return View::make('regla/modificarprecio', 
		        				[
		        					'regla'  		=> $regla,
									'fechavacia'  	=> $fechavacia,
						  			'idopcion' 		=> $idopcion
		        				]);
		}
	}




	public function actionListarReglaCupones($idopcion)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $listacupones = WEBRegla::orderBy('fechafin', 'asc')
	    				->where('tiporegla','=','CUP')
	    				//->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
	    				//->where('centro_id','=',Session::get('centros')->COD_CENTRO)
	    				->get();


		$fechavacia  = $this->fechavacia;


		return View::make('regla/listacupones',
						 [
						 	'listacupones' 	=> $listacupones,
						 	'idopcion' 		=> $idopcion,
							'fechavacia'  	=> $fechavacia,
						 ]);
	}

	public function actionAjaxGenerarCupon()
	{
		echo($this->funciones->codecupon());
	}


	public function actionAgregarCupon($idopcion,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}

	    /******************************************************/

		if($_POST)
		{

			$codigo 					= 	$this->funciones->generar_codigo('WEB.reglas',6);
			$idregla 					= 	$this->funciones->getCreateIdMaestra('WEB.reglas');

			$cabecera            	 	=	new WEBRegla;
			$cabecera->id 	     	 	=  	$idregla;
			$cabecera->codigo 	    	=  	$codigo;
			$cabecera->tiporegla 	    =  	'CUP';
			$cabecera->nombre 	     	=  	trim($request['nombre']);
			$cabecera->descripcion 	    =  	trim($request['descripcion']);
			$cabecera->cupon 	     	=  	trim($request['cupon']);
			$cabecera->fechainicio 	    =  	trim($request['fechainicio']);
			$cabecera->fechafin 	    =  	trim($request['fechafin']);
			$cabecera->cantidadminima 	=  	trim($request['cantidadminima']);
			$cabecera->totaldisponible 	=  	trim($request['totaldisponible']);
			$cabecera->totalcadacuenta 	=  	trim($request['totalcadacuenta']);
			$cabecera->tipodescuento 	=  	trim($request['tipodescuento']);
			$cabecera->descuento 		=  	trim($request['descuento']);
			$cabecera->estado 			=  	trim($request['estado']);
			$cabecera->fecha_crea 	    =  	$this->fechaactual;
			$cabecera->usuario_crea 	=  	Session::get('usuario')->id;
			$cabecera->empresa_id 		=   Session::get('empresas')->COD_EMPR;
			$cabecera->centro_id 		=   Session::get('centros')->COD_CENTRO;
			$cabecera->save();
 

 			return Redirect::to('/gestion-de-regla-de-cupon-producto/'.$idopcion)->with('bienhecho', 'Cupón '.$request['nombre'].' registrado con exito');


		}else{

			$fechaactual = $this->fechaactualinput;
			$fechavacia  = $this->fechavacia;

			return View::make('regla/agregarcupon',
						[				
							'fechaactual'  		=> $fechaactual,
							'fechavacia'  		=> $fechavacia,	
						  	'idopcion'  		=> $idopcion,
						]);
		}
	}



	public function actionModificarCupon($idopcion,$idregla,Request $request)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Modificar');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
	    $idregla = $this->funciones->decodificarmaestra($idregla);

		if($_POST)
		{

			$cabecera            	 	=	WEBRegla::find($idregla);
			$cabecera->nombre 	     	=  	trim($request['nombre']);
			$cabecera->descripcion 	    =  	trim($request['descripcion']);
			$cabecera->cupon 	     	=  	trim($request['cupon']);
			$cabecera->fechainicio 	    =  	trim($request['fechainicio']);
			$cabecera->fechafin 	    =  	trim($request['fechafin']);
			$cabecera->cantidadminima 	=  	trim($request['cantidadminima']);
			$cabecera->totaldisponible 	=  	trim($request['totaldisponible']);
			$cabecera->totalcadacuenta 	=  	trim($request['totalcadacuenta']);
			$cabecera->tipodescuento 	=  	trim($request['tipodescuento']);
			$cabecera->descuento 		=  	trim($request['descuento']);
			$cabecera->estado 			=  	trim($request['estado']);
			$cabecera->fecha_mod 	    =  	$this->fechaactual;
			$cabecera->usuario_mod 		=  	Session::get('usuario')->id;
			$cabecera->save();
 
 			return Redirect::to('/gestion-de-regla-de-cupon-producto/'.$idopcion)->with('bienhecho', 'Cupón '.$request['nombre'].' modificado con éxito');


		}else{


				$regla = WEBRegla::where('id', $idregla)->first();
				$fechavacia  = $this->fechavacia;
	
		        return View::make('regla/modificarcupon', 
		        				[
		        					'regla'  		=> $regla,
									'fechavacia'  		=> $fechavacia,
						  			'idopcion' 		=> $idopcion
		        				]);
		}
	}



}
/*Nexmo::message()->send([
    'to'   => '51979529813',
    'from' => '51979820173',
    'text' => 'Mensaje desde laravel'
]);*/