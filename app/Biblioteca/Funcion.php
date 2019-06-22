<?php
namespace App\Biblioteca;
use DB,Hashids,Session,Redirect,table;
use App\WEBRolOpcion,App\WEBListaCliente,App\STDTipoDocumento,App\WEBPrecioProducto,App\WEBReglaProductoCliente;
use App\WEBRegla,App\WEBUserEmpresaCentro;
use Keygen;

class Funcion{


	public function cuenta_cliente($id_cliente) {
		
		$cuenta 		= 		DB::table('WEB.LISTACLIENTE')
        							->where('id','=',$id_cliente)
        							->first();

	 	return  $cuenta->CONTRATO;					 			
	}


	public function tipo_cambio() {
		
		$tipocambio 		= 		DB::table('WEB.VIEWTIPOCAMBIO')
        							->where('FEC_CAMBIO','<=',date('d/m/Y'))
        							->orderBy('FEC_CAMBIO', 'desc')
        							->first();

        return $tipocambio; 							
	}




	public function desencriptar_id($id,$count) {
		
		$idarray = explode('-', $id);
	  	//decodificar variable
	  	$decid 	= Hashids::decode($idarray[1]);
	  	//ver si viene con letras la cadena codificada
	  	if(count($decid)==0){ 
	  		return Redirect::back()->withInput()->with('errorurl', 'Indices de la url con errores'); 
	  	}
	  	//concatenar con ceros
	  	$idcompleta = str_pad($decid[0], $count, "0", STR_PAD_LEFT); 
	  	//concatenar prefijo
		$idcompleta = $idarray[0].$idcompleta;
		return $idcompleta;
	}


	public function calcular_cabecera_total($productos) {

		$total 						=   0.0000;
		$productos 					= 	json_decode($productos, true);

		foreach($productos as $obj){
			$total = $total + (float)$obj['precio_producto']*(float)$obj['cantidad_producto'];
		}
		return $total;
	}

	public function calculo_igv($monto) {
	  	return $monto - ($monto/1.18);
	}
	public function calculo_subtotal($monto) {
	  	return $monto/1.18;
	}

	public function generar_codigo($basedatos,$cantidad) {

	  		// maximo valor de la tabla referente
			$tabla = DB::table($basedatos)
            ->select(DB::raw('max(codigo) as codigo'))
            ->get();

            //conversion a string y suma uno para el siguiente id
            $idsuma = (int)$tabla[0]->codigo + 1;

		  	//concatenar con ceros
		  	$correlativocompleta = str_pad($idsuma, $cantidad, "0", STR_PAD_LEFT); 

	  		return $correlativocompleta;

	}

	public function tiene_perfil($empresa_id,$centro_id,$usuario_id) {

		$perfiles 		=   WEBUserEmpresaCentro::where('empresa_id','=',$empresa_id)
							->where('centro_id','=',$centro_id)
							->where('usuario_id','=',$usuario_id)
							->where('activo','=','1')
							->first();

		if(count($perfiles)>0){
			return true;
		}else{
			return false;
		}	

	}

	public function precio_regla_calculo_menor_cero($producto_id,$cliente_id,$mensaje,$tiporegla,$regla_id) {

		$mensaje					=   $mensaje;
		$error						=   false;
		$precio 					=   WEBPrecioProducto::where('producto_id','=',$producto_id)->first();
		$regla 						=   WEBRegla::where('id','=',$regla_id)->first();

		$calculo 					= 	$this->calculo_precio_regla($regla->tipodescuento,$precio->precio,$regla->descuento,$regla->descuentoaumento);

		if($calculo < 0 && $regla->descuentoaumento <> 'AU'){
			$mensaje = 'La regla afecta al precio del producto en un valor negativo';
			$error   = true;
		}								

		$response[] = array(
			'error'           		=> $error,
			'mensaje'      			=> $mensaje
		);

		return $response;
	}


	public function calculo_precio_regla($tipodescuento,$precio,$descuento,$aumentodescuento) {

		//calculo entre el producto y la regla
		$calculo = 0;
		if($tipodescuento == 'IMP'){
			if($aumentodescuento == 'AU'){
				$calculo = $precio + $descuento;
			}else{
				$calculo = $precio - $descuento;
			}
		}else{
			if($aumentodescuento == 'AU'){
				$calculo = $precio + $precio * ($descuento/100);
			}else{
				$calculo = $precio - $precio * ($descuento/100);
			}
		}
		return $calculo;

	}



	public function tiene_regla_activa($producto_id,$cliente_id,$contrato_id,$mensaje,$tiporegla) {

		$mensaje					=   $mensaje;
		$error						=   false;
		$cantidad 					=  	0;

		$listareglas = 	WEBReglaProductoCliente::join('WEB.reglas', 'WEB.reglaproductoclientes.regla_id', '=', 'WEB.reglas.id')
						->where('producto_id','=',$producto_id)
						->where('WEB.reglas.tiporegla','=',$tiporegla)
						->where('cliente_id','=',$cliente_id)
						->where('contrato_id','=',$contrato_id)
						->where('WEB.reglaproductoclientes.activo','=','1')
						->get();

		if($tiporegla=='PNC' or $tiporegla=='POV'){
			$cantidad = 2; //osea si tiene 3 reglas
		}

		if(count($listareglas) > $cantidad ){
			$mensaje = 'Tienes una regla activa por el momento';
			$error   = true;
		}								

		$response[] = array(
			'error'           		=> $error,
			'mensaje'      			=> $mensaje
		);

		return $response;

	}


	public function reglas_actualizar_modal($producto_id,$cliente_id,$contrato_id,$tiporegla) {

		$listareglas = 	WEBReglaProductoCliente::join('WEB.reglas', 'WEB.reglaproductoclientes.regla_id', '=', 'WEB.reglas.id')
						->select('WEB.reglaproductoclientes.*')
						->where('producto_id','=',$producto_id)
						->where('WEB.reglas.tiporegla','=',$tiporegla)
						->where('cliente_id','=',$cliente_id)
						->where('contrato_id','=',$contrato_id)
						->orderBy('WEB.reglaproductoclientes.activo', 'desc')
						->orderBy('WEB.reglaproductoclientes.fecha_crea', 'desc')
						->take(5)
						->get();

	 	return  $listareglas;
	}

	public function combo_activas_regla_tipo($tipo,$nombreselect) {



		$lista_activas 		= 	WEBRegla::where('activo','=',1)
								->where('tiporegla','=',$tipo)
								->where('estado','=','PU')
								->select('id', DB::raw("(CASE WHEN descuentoaumento = 'AU' THEN nombre + ' aumento'  WHEN descuentoaumento = 'DS' THEN  nombre + ' descuento' ELSE nombre END) AS nombre"))
								->pluck('nombre','id')
								->toArray();

		$comboreglas 		= 	array('' => "Seleccione ".$nombreselect) + $lista_activas;

	 	return  $comboreglas;

	}

	
	public function nombre_producto_seleccionado($idproducto) {

		$nombre 						= 	WEBPrecioProducto::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
											->where('producto_id','=',$idproducto)
					    					//->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
					    					//->where('centro_id','=',Session::get('centros')->COD_CENTRO)
	    					 				->first();
	 	return    $nombre->NOM_PRODUCTO;					 			
	}


	public function lista_productos_precio_buscar($idproducto) {

		if($idproducto != ''){
			$lista_producto_precio 		= 	WEBPrecioProducto::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
											->where('producto_id','=',$idproducto)
					    					//->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
					    					//->where('centro_id','=',Session::get('centros')->COD_CENTRO)
	    					 				->orderBy('NOM_PRODUCTO', 'asc')
	    					 				->get();
		}else{
			$lista_producto_precio 		= 	$this->lista_productos_precio();
		}

	 	return    $lista_producto_precio;					 			
	}


	public function producto_buscar($idproducto) {

		$producto 		= 	WEBPrecioProducto::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
							->where('producto_id','=',$idproducto)
    					 	->first();

	 	return    $producto;					 			
	}

	public function regla_buscar($regla_id){

		$regla 		= 	WEBRegla::where('id','=',$regla_id)
    					->first();

	 	return    $regla;					 			
	}

	public function cliente_buscar($cliente_id) {

		$cliente 		= 	WEBListaCliente::where('id','=',$cliente_id)
    						->first();

	 	return    $cliente;					 			
	}



	public function lista_productos_precio() {

		$lista_producto_precio 		= 	WEBPrecioProducto::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
					    				//->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
					    				//->where('centro_id','=',Session::get('centros')->COD_CENTRO)
	    					 			->orderBy('NOM_PRODUCTO', 'asc')->get();
	 	return    $lista_producto_precio;					 			
	}


	public function combo_nombres_lista_productos() {

		$lista_producto_precio 		= 	WEBPrecioProducto::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
						    			//->where('empresa_id','=',Session::get('empresas')->COD_EMPR)
						    			//->where('centro_id','=',Session::get('centros')->COD_CENTRO)
										->pluck('NOM_PRODUCTO','producto_id')
										->take(10)
										->toArray();

		$combolistaproductos  		= 	array('' => "Seleccione producto") + $lista_producto_precio;

	 	return  $combolistaproductos;					 			
	}

	public function combo_nombres_lista_clientes() {

		$listaclientes   		=	WEBListaCliente::select('NOM_EMPR')
					    			->where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
					    			//->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
									->pluck('NOM_EMPR','NOM_EMPR')
									->take(10)
									->toArray();

		$combolistaclientes  	= 	array('' => "Seleccione clientes") + $listaclientes;
		return $combolistaclientes;					 			
	}






	public function respuestavacio($cliente,$producto_select) {

		if(!is_null($cliente)){
			return false;
		}
		if(!is_null($producto_select)){
			return false;
		}

		return true;
	}

	public function array_id_clientes_top($cantidad){
		$arrayidclientes   			=	WEBListaCliente::where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
					    				->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
										->take($cantidad)->pluck('id')->toArray();
		return $arrayidclientes;
	}

	public function combotipodocumentoxclientes() {

		$arraytipodocumentocliente   	=	WEBListaCliente::select('COD_TIPO_DOCUMENTO','NOM_TIPO_DOCUMENTO')
											->groupBy('COD_TIPO_DOCUMENTO')
											->groupBy('NOM_TIPO_DOCUMENTO')
											->where('COD_TIPO_DOCUMENTO','!=','')
					    					->where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
					    					->where('COD_CENTRO','=',Session::get('centros')->COD_CENTRO)
											->pluck('NOM_TIPO_DOCUMENTO','COD_TIPO_DOCUMENTO')
											->toArray();

		$combotipodocumento  			= 	array('' => "Seleccione tipo documento") + $arraytipodocumentocliente;

		return $combotipodocumento;

	}

	public function getUrl($idopcion,$accion) {

	  	//decodificar variable
	  	$decidopcion = Hashids::decode($idopcion);
	  	//ver si viene con letras la cadena codificada
	  	if(count($decidopcion)==0){ 
	  		return Redirect::back()->withInput()->with('errorurl', 'Indices de la url con errores'); 
	  	}

	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($decidopcion[0], 8, "0", STR_PAD_LEFT); 
	  	//concatenar prefijo

	  	// hemos hecho eso porque ahora el prefijo va hacer fijo en todas las empresas que 1CIX
		//$prefijo = Local::where('activo', '=', 1)->first();
		//$idopcioncompleta = $prefijo->prefijoLocal.$idopcioncompleta;
		$idopcioncompleta = '1CIX'.$idopcioncompleta;

	  	// ver si la opcion existe
	  	$opcion =  WEBRolOpcion::where('opcion_id', '=',$idopcioncompleta)
	  			   ->where('rol_id', '=',Session::get('usuario')->rol_id)
	  			   ->where($accion, '=',1)
	  			   ->first();

	  	if(count($opcion)<=0){
	  		return Redirect::back()->withInput()->with('errorurl', 'No tiene autorización para '.$accion.' aquí');
	  	}
	  	return 'true';

	 }

	public function prefijomaestra() {

		$prefijo = '1CIX';
	  	return $prefijo;
	}

	public function getCreateIdMaestra($tabla) {

  		$id="";

  		// maximo valor de la tabla referente
		$id = DB::table($tabla)
        ->select(DB::raw('max(SUBSTRING(id,5,8)) as id'))
        ->get();

        //conversion a string y suma uno para el siguiente id
        $idsuma = (int)$id[0]->id + 1;

	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($idsuma, 8, "0", STR_PAD_LEFT);

	  	//concatenar prefijo
		$prefijo = $this->prefijomaestra();

		$idopcioncompleta = $prefijo.$idopcioncompleta;

  		return $idopcioncompleta;	

	}

	public function decodificarmaestra($id) {

	  	//decodificar variable
	  	$iddeco = Hashids::decode($id);
	  	//ver si viene con letras la cadena codificada
	  	if(count($iddeco)==0){ 
	  		return ''; 
	  	}
	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($iddeco[0], 8, "0", STR_PAD_LEFT); 
	  	//concatenar prefijo

		//$prefijo = Local::where('activo', '=', 1)->first();

		// apunta ahi en tu cuaderno porque esto solo va a permitir decodifcar  cuando sea el contrato del locl en donde estas del resto no 
		//¿cuando sea el contrato del local?
		$prefijo = $this->prefijomaestra();
		$idopcioncompleta = $prefijo.$idopcioncompleta;
	  	return $idopcioncompleta;

	}


	public function decodificarid($id,$prefijo) {

	  	//decodificar variable
	  	$iddeco = Hashids::decode($id);
	  	//ver si viene con letras la cadena codificada
	  	if(count($iddeco)==0){ 
	  		return ''; 
	  	}
	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($iddeco[0], 13, "0", STR_PAD_LEFT); 
	  	//concatenar prefijo
		$idopcioncompleta = $prefijo.$idopcioncompleta;
	  	return $idopcioncompleta;

	}

	public function codecupon(){
	  	return Hashids::encode(Keygen::numeric(10)->generate());
	}





}

