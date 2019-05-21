<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\User,App\WEBGrupoopcion,App\WEBRol,App\WEBRolOpcion,App\WEBOpcion,App\WEBListaPersonal;
use View;
use Session;
use Hashids;


class UserController extends Controller
{

    public function actionLogin(Request $request){

		if($_POST)
		{
			/**** Validaciones laravel ****/
			$this->validate($request, [
	            'name' => 'required',
	            'password' => 'required',

			], [
            	'name.required' => 'El campo Usuario es obligatorio',
            	'password.required' => 'El campo Clave es obligatorio',
        	]);

			/**********************************************************/
			
			$usuario 	 				 = strtoupper($request['name']);
			$clave   	 				 = strtoupper($request['password']);
			$local_id  	 				 = $request['local_id'];

			$tusuario    				 = User::whereRaw('UPPER(name)=?',[$usuario])->first();

			if(count($tusuario)>0)
			{
				$clavedesifrada 		 = 	strtoupper(Crypt::decrypt($tusuario->password));

				if($clavedesifrada == $clave)
				{
					$listamenu    		 = 	WEBGrupoopcion::where('activo', '=', 1)->orderBy('orden', 'asc')->get();

					Session::put('usuario', $tusuario);
					Session::put('listamenu', $listamenu);

					return Redirect::to('bienvenido');
					
						
				}else{
					return Redirect::back()->withInput()->with('errorbd', 'Usuario o clave incorrecto');
				}	
			}else{
				return Redirect::back()->withInput()->with('errorbd', 'Usuario o clave incorrecto');
			}						    

		}else{
			return view('usuario.login');
		}
    }

	public function actionBienvenido()
	{
		return View::make('bienvenido');
	}

	public function actionCerrarSesion()
	{

		Session::forget('usuario');
		Session::forget('listamenu');
		return Redirect::to('/login');
	}


	public function actionListarUsuarios($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');

	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
	    $listausuarios = User::where('id','<>',$this->prefijomaestro.'00000001')->orderBy('id', 'asc')->get();

		return View::make('usuario/listausuarios',
						 [
						 	'listausuarios' => $listausuarios,
						 	'idopcion' => $idopcion,
						 ]);
	}


	public function actionAgregarUsuario($idopcion,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}

	    /******************************************************/

		if($_POST)
		{


			$personal_id 	 		 	= 	$request['personal'];
			$personal     				=   WEBListaPersonal::where('id', '=', $personal_id)->first();
			$idusers 				 	=   $this->funciones->getCreateIdMaestra('users');
			
			$cabecera            	 	=	new User;
			$cabecera->id 	     	 	=   $idusers;
			$cabecera->nombre 	     	=   $personal->nombres;
			$cabecera->name  		 	=	$request['name'];
			$cabecera->passwordmobil  	=	$request['password'];
			$cabecera->password 	 	= 	Crypt::encrypt($request['password']);
			$cabecera->rol_id 	 		= 	$request['rol_id'];
			$cabecera->usuarioosiris_id	= 	$personal->id;
			$cabecera->save();
 

 			return Redirect::to('/gestion-de-usuarios/'.$idopcion)->with('bienhecho', 'Usuario '.$personal->nombres.' registrado con exito');

		}else{

			$listapersonal 				= 	DB::table('WEB.LISTAPERSONAL')
	    									->leftJoin('users', 'WEB.LISTAPERSONAL.id', '=', 'users.usuarioosiris_id')
	    									->whereNull('users.usuarioosiris_id')
	    									->select('WEB.LISTAPERSONAL.id','WEB.LISTAPERSONAL.nombres')
	    									->get();

			$rol 						= 	DB::table('WEB.Rols')->where('id','<>',$this->prefijomaestro.'00000001')->pluck('nombre','id')->toArray();
			$comborol  					= 	array('' => "Seleccione Rol") + $rol;
		
			return View::make('usuario/agregarusuario',
						[
							'comborol'  		=> $comborol,
							'listapersonal'  	=> $listapersonal,					
						  	'idopcion'  		=> $idopcion
						]);
		}
	}


	public function actionModificarUsuario($idopcion,$idusuario,Request $request)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Modificar');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
	    $idusuario = $this->funciones->decodificarmaestra($idusuario);

		if($_POST)
		{

			$cabecera            	 =	User::find($idusuario);			
			$cabecera->name  		 =	$request['name'];
			$cabecera->passwordmobil =	$request['password'];
			$cabecera->password 	 = 	Crypt::encrypt($request['password']);
			$cabecera->activo 	 	 =  $request['activo'];			
			$cabecera->rol_id 	 	 = 	$request['rol_id']; 
			$cabecera->save();


 			return Redirect::to('/gestion-de-usuarios/'.$idopcion)->with('bienhecho', 'Usuario '.$request['nombre'].' modificado con exito');


		}else{


				$usuario 	= User::where('id', $idusuario)->first();  
				$rol 		= DB::table('WEB.Rols')->where('id','<>',$this->prefijomaestro.'00000001')->pluck('nombre','id')->toArray();
				$comborol  	= array($usuario->rol_id => $usuario->rol->nombre) + $rol;
			

		        return View::make('usuario/modificarusuario', 
		        				[
		        					'usuario'  		=> $usuario,
									'comborol' 		=> $comborol,
						  			'idopcion' 		=> $idopcion,					  			
		        				]);
		}
	}




	public function actionListarRoles($idopcion)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $listaroles = WEBRol::where('id','<>',$this->prefijomaestro.'00000001')->orderBy('id', 'asc')->get();

		return View::make('usuario/listaroles',
						 [
						 	'listaroles' => $listaroles,
						 	'idopcion' => $idopcion,
						 ]);

	}


	public function actionAgregarRol($idopcion,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

		if($_POST)
		{

			/**** Validaciones laravel ****/
			
			$this->validate($request, [
			    'nombre' => 'unico:WEB,rols',
			], [
            	'nombre.unico' => 'Rol ya registrado',
        	]);

			/******************************/
			$idrol 					 = $this->funciones->getCreateIdMaestra('WEB.rols');

			$cabecera            	 =	new WEBRol;
			$cabecera->id 	     	 =  $idrol;
			$cabecera->nombre 	     =  $request['nombre'];
			$cabecera->save();

			$listaopcion = WEBOpcion::orderBy('id', 'asc')->get();
			$count = 1;
			foreach($listaopcion as $item){


				$idrolopciones 		= $this->funciones->getCreateIdMaestra('WEB.rolopciones');


			    $detalle            =	new WEBRolOpcion;
			    $detalle->id 	    =  	$idrolopciones;
				$detalle->opcion_id = 	$item->id;
				$detalle->rol_id    =  	$idrol;
				$detalle->orden     =  	$count;
				$detalle->ver       =  	0;
				$detalle->anadir    =  	0;
				$detalle->modificar =  	0;
				$detalle->eliminar  =  	0;
				$detalle->todas     = 	0;
				$detalle->save();
				$count 				= 	$count +1;
			}

 			return Redirect::to('/gestion-de-roles/'.$idopcion)->with('bienhecho', 'Rol '.$request['nombre'].' registrado con exito');
		}else{

		
			return View::make('usuario/agregarrol',
						[
						  	'idopcion' => $idopcion
						]);

		}
	}


	public function actionModificarRol($idopcion,$idrol,Request $request)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Modificar');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
	    $idrol = $this->funciones->decodificarmaestra($idrol);

		if($_POST)
		{

			/**** Validaciones laravel ****/
			$this->validate($request, [
				'nombre' => 'unico_menos:WEB,rols,id,'.$idrol,
			], [
            	'nombre.unico_menos' => 'Rol ya registrado',
        	]);
			/******************************/

			$cabecera            	 =	WEBRol::find($idrol);
			$cabecera->nombre 	     =  $request['nombre'];
			$cabecera->activo 	 	 =  $request['activo'];			
			$cabecera->save();
 
 			return Redirect::to('/gestion-de-roles/'.$idopcion)->with('bienhecho', 'Rol '.$request['nombre'].' modificado con éxito');

		}else{
				$rol = WEBRol::where('id', $idrol)->first();

		        return View::make('usuario/modificarrol', 
		        				[
		        					'rol'  		=> $rol,
						  			'idopcion' 	=> $idopcion
		        				]);
		}
	}



	public function actionListarPermisos($idopcion)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

	    $listaroles = WEBRol::where('id','<>',$this->prefijomaestro.'00000001')->orderBy('id', 'asc')->get();

		return View::make('usuario/listapermisos',
						 [
						 	'listaroles' => $listaroles,
						 	'idopcion' => $idopcion,
						 ]);
	}


	public function actionAjaxListarOpciones(Request $request)
	{
		$idrol =  $request['idrol'];
		$idrol = $this->funciones->decodificarmaestra($idrol);

		$listaopciones = WEBRolOpcion::where('rol_id','=',$idrol)->get();

		return View::make('usuario/ajax/listaopciones',
						 [
							 'listaopciones'   => $listaopciones
						 ]);
	}

	public function actionAjaxActivarPermisos(Request $request)
	{

		$idrolopcion =  $request['idrolopcion'];
		$idrolopcion = $this->funciones->decodificarmaestra($idrolopcion);

		$cabecera            	 =	WEBRolOpcion::find($idrolopcion);
		$cabecera->ver 	     	 =  $request['ver'];
		$cabecera->anadir 	 	 =  $request['anadir'];	
		$cabecera->modificar 	 =  $request['modificar'];
		$cabecera->todas 	 	 =  $request['todas'];	
		$cabecera->save();

		echo("gmail");

	}
	


}