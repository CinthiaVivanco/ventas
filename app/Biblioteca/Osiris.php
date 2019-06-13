<?php
namespace App\Biblioteca;

use DOMDocument;
use DB;
use Session;
use PDO;

class Osiris{

	public $msjerror;
	public $orden_id;
	public $lote;

	public function __construct()
	{
	    $this->msjerror 	= '';
	    $this->orden_id 	= '';
	    $this->lote 		= '';
	}


	/************** GUARDAR ORDEN DE PEDIDO ****************/


	public function guardar_orden_pedido($pedido) {


        if ($pedido->estado!='EM') { $this->msjerror = 'Documento ya fue aceptado'; return false;}


		$glosa 				= '';

		/**************************************** GLOSA ORDEN  *************************************/				
		foreach($pedido->detallepedido as $item){
			$glosa = 	$glosa . $item->producto->NOM_PRODUCTO.',';
		}	

	 	/**************************************** GUARDAR ORDEN  *************************************/

		$vacio 						=       '';
		$accion 					= 	'I';
		$cod_empr 					= 	$pedido->empresa_id;
		$cod_empr_cliente 			        = 	$pedido->cliente_id;
		$txt_empr_cliente			        = 	$pedido->empresa->NOM_EMPR;
		$cod_centro 				        =       $pedido->centro_id;
		$fecha_venta 				        =       date_format(date_create(date('d-m-Y')), 'Y-m-d');
		$fecha_ilimitada 			        =       date_format(date_create('1901-01-01'), 'Y-m-d');;
		$ind_material_servicio 		                = 	'M';
		$cod_categoria_tipo_orden 	                = 	'TOR0000000000006';
		$txt_categoria_tipo_orden 	                = 	'VENTAS COMERCIAL';

		$cod_categoria_moneda 		                = 	'MON0000000000001';
		$txt_categoria_moneda		                =       'SOLES';
                
		$cod_categoria_estado_orden	                = 	'EOR0000000000001';
		$txt_categoria_estado_orden	                = 	'GENERADA';
		$cod_contrato				        = 	$pedido->cuenta_id;
		$cod_cultivo				        = 	'CCU0000000000001';
		$can_sub_total				        = 	(string)$pedido->total;
		$can_total					= 	(string)$pedido->total;
		$valor_cero					= 	'0';
		$can_tipo_cambio 			        = 	'3.2940';
		$cod_categoria_modulo 		                = 	'MSI0000000000010';
		$txt_glosa_atencion 		                = 	$glosa;
		$cod_estado 				        =       '1';
		$cod_usuario_registro 		                =       Session::get('usuario')->name;
		$cod_categoria_actividad_negocio 		=       'VENTA_MERCADERIA';


		$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.ORDEN_IUD ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?');
                $stmt->bindParam(1, $accion ,PDO::PARAM_STR);					//@IND_TIPO_OPERACION='I',
                $stmt->bindParam(2, $vacio  ,PDO::PARAM_STR);					//@COD_ORDEN='',
                $stmt->bindParam(3, $cod_empr ,PDO::PARAM_STR); 				//@COD_EMPR='IACHEM0000010394',
                $stmt->bindParam(4, $cod_empr_cliente ,PDO::PARAM_STR); 		        //@COD_EMPR_CLIENTE='IACHEM0000010862',
                $stmt->bindParam(5, $txt_empr_cliente ,PDO::PARAM_STR); 		        //@TXT_EMPR_CLIENTE='VIVANCO GONZALES CINTHIA MIRELLA',
                $stmt->bindParam(6, $vacio  ,PDO::PARAM_STR); 					//@COD_EMPR_LICITACION='',
                $stmt->bindParam(7, $vacio  ,PDO::PARAM_STR);					//@TXT_EMPR_LICITACION='',
                $stmt->bindParam(8, $vacio  ,PDO::PARAM_STR);					//@COD_EMPR_TRANSPORTE='',
                $stmt->bindParam(9, $vacio  ,PDO::PARAM_STR);					//@TXT_EMPR_TRANSPORTE='',
                $stmt->bindParam(10, $vacio  ,PDO::PARAM_STR);					//@COD_EMPR_ORIGEN='',

                $stmt->bindParam(11, $vacio  ,PDO::PARAM_STR); 					//@TXT_EMPR_ORIGEN='',
                $stmt->bindParam(12, $cod_centro ,PDO::PARAM_STR);				//@COD_CENTRO='CEN0000000000001',
                $stmt->bindParam(13, $vacio  ,PDO::PARAM_STR);					//@COD_CENTRO_DESTINO='',
                $stmt->bindParam(14, $vacio  ,PDO::PARAM_STR);					//@COD_CENTRO_ORIGEN='',
                $stmt->bindParam(15, $fecha_venta ,PDO::PARAM_STR);				//@FEC_ORDEN='2019-06-12', 
                $stmt->bindParam(16, $fecha_venta ,PDO::PARAM_STR);				//@FEC_RECEPCION='2019-06-12', 
                $stmt->bindParam(17, $fecha_venta ,PDO::PARAM_STR);				//@FEC_ENTREGA='2019-06-12',
                $stmt->bindParam(18, $fecha_ilimitada ,PDO::PARAM_STR);			        //@FEC_ENTREGA_2='1901-01-01',
                $stmt->bindParam(19, $fecha_ilimitada ,PDO::PARAM_STR);			        //@FEC_ENTREGA_3='1901-01-01',
                $stmt->bindParam(20, $fecha_venta ,PDO::PARAM_STR);				//@FEC_PAGO='2019-06-12',

                $stmt->bindParam(21, $fecha_venta ,PDO::PARAM_STR); 			        //@FEC_NOTA_PEDIDO='2019-06-12',
                $stmt->bindParam(22, $fecha_venta ,PDO::PARAM_STR);				//@FEC_RECOJO_MERCADERIA='2019-06-12',
                $stmt->bindParam(23, $fecha_venta ,PDO::PARAM_STR);				//@FEC_ENTREGA_LIMA='2019-06-12',
                $stmt->bindParam(24, $fecha_venta ,PDO::PARAM_STR);				//@FEC_GRACIA='2019-06-12',
                $stmt->bindParam(25, $fecha_ilimitada ,PDO::PARAM_STR);			        //@FEC_EJECUCION='1901-01-01',
                $stmt->bindParam(26, $ind_material_servicio ,PDO::PARAM_STR);	                //@IND_MATERIAL_SERVICIO='M', 
                $stmt->bindParam(27, $vacio  ,PDO::PARAM_STR);					//@COD_CATEGORIA_ESTADO_REQ='',
                $stmt->bindParam(28, $cod_categoria_tipo_orden ,PDO::PARAM_STR);                //@COD_CATEGORIA_TIPO_ORDEN='TOR0000000000006',
                $stmt->bindParam(29, $txt_categoria_tipo_orden ,PDO::PARAM_STR);                //@TXT_CATEGORIA_TIPO_ORDEN='VENTAS COMERCIAL',
                $stmt->bindParam(30, $vacio  ,PDO::PARAM_STR);					//@COD_CATEGORIA_TIPO_PAGO='',

                $stmt->bindParam(31, $cod_categoria_moneda ,PDO::PARAM_STR); 	                //@COD_CATEGORIA_MONEDA='MON0000000000001',
                $stmt->bindParam(32, $txt_categoria_moneda ,PDO::PARAM_STR);	                //@TXT_CATEGORIA_MONEDA='SOLES',
                $stmt->bindParam(33, $cod_categoria_estado_orden ,PDO::PARAM_STR);              //@COD_CATEGORIA_ESTADO_ORDEN='EOR0000000000001',
                $stmt->bindParam(34, $txt_categoria_estado_orden ,PDO::PARAM_STR);              //@TXT_CATEGORIA_ESTADO_ORDEN='GENERADA',
                $stmt->bindParam(35, $vacio  ,PDO::PARAM_STR);					//@COD_CATEGORIA_MOVIMIENTO_INVENTARIO='',
                $stmt->bindParam(36, $vacio  ,PDO::PARAM_STR); 					//@TXT_CATEGORIA_MOVIMIENTO_INVENTARIO='',
                $stmt->bindParam(37, $vacio  ,PDO::PARAM_STR);					//@COD_CATEGORIA_PROCESO_SEL='',
                $stmt->bindParam(38, $vacio  ,PDO::PARAM_STR);					//@TXT_CATEGORIA_PROCESO_SEL='',
                $stmt->bindParam(39, $vacio  ,PDO::PARAM_STR);					//@COD_CATEGORIA_MODALIDAD_SEL='',
                $stmt->bindParam(40, $vacio  ,PDO::PARAM_STR);					//@TXT_CATEGORIA_MODALIDAD_SEL='',

                $stmt->bindParam(41, $vacio  ,PDO::PARAM_STR);					//@COD_CATEGORIA_AREA_EMPRESA='',
                $stmt->bindParam(42, $vacio  ,PDO::PARAM_STR);					//@TXT_CATEGORIA_AREA_EMPRESA='',
                $stmt->bindParam(43, $vacio  ,PDO::PARAM_STR);					//@COD_CONCEPTO_CENTRO_COSTO='',
                $stmt->bindParam(44, $vacio  ,PDO::PARAM_STR);					//@COD_CHOFER='',
                $stmt->bindParam(45, $vacio  ,PDO::PARAM_STR);					//@COD_VEHICULO='',
                $stmt->bindParam(46, $vacio  ,PDO::PARAM_STR);					//@COD_CARRETA='', 
                $stmt->bindParam(47, $vacio  ,PDO::PARAM_STR);					//@TXT_CARRETA='',
                $stmt->bindParam(48, $vacio  ,PDO::PARAM_STR);					//@COD_CONTRATO_ORIGEN='',
                $stmt->bindParam(49, $vacio  ,PDO::PARAM_STR);					//@COD_CULTIVO_ORIGEN='',
                $stmt->bindParam(50, $vacio  ,PDO::PARAM_STR);					//@COD_CONTRATO_LICITACION='',

                $stmt->bindParam(51, $vacio  ,PDO::PARAM_STR);					//@COD_CULTIVO_LICITACION='', 
                $stmt->bindParam(52, $vacio  ,PDO::PARAM_STR);					//@COD_CONTRATO_TRANSPORTE='',
                $stmt->bindParam(53, $vacio  ,PDO::PARAM_STR);					//@COD_CULTIVO_TRANSPORTE='',
                $stmt->bindParam(54, $cod_contrato ,PDO::PARAM_STR);			        //@COD_CONTRATO='IICHRC0000002443',
                $stmt->bindParam(55, $cod_cultivo ,PDO::PARAM_STR);				//@COD_CULTIVO='CCU0000000000001',
                $stmt->bindParam(56, $vacio  ,PDO::PARAM_STR); 					//@COD_HABILITACION='',
                $stmt->bindParam(57, $vacio  ,PDO::PARAM_STR);					//@COD_HABILITACION_DCTO='',
                $stmt->bindParam(58, $vacio  ,PDO::PARAM_STR);					//@COD_ALMACEN_ORIGEN='',
                $stmt->bindParam(59, $vacio  ,PDO::PARAM_STR);					//@COD_ALMACEN_DESTINO='',
                $stmt->bindParam(60, $vacio  ,PDO::PARAM_STR);					//@COD_TRABAJADOR_SOLICITA='',

                $stmt->bindParam(61, $vacio  ,PDO::PARAM_STR);					//@COD_TRABAJADOR_ENCARGADO='', 
                $stmt->bindParam(62, $vacio  ,PDO::PARAM_STR);					//@COD_TRABAJADOR_COMISIONISTA='',
                $stmt->bindParam(63, $vacio  ,PDO::PARAM_STR);					//@COD_CONTRATO_COMISIONISTA='',
                $stmt->bindParam(64, $vacio  ,PDO::PARAM_STR);					//@COD_CULTIVO_COMISIONISTA='',
                $stmt->bindParam(65, $vacio  ,PDO::PARAM_STR);					//@COD_HABILITACION_COMISIONISTA='',
                $stmt->bindParam(66, $vacio  ,PDO::PARAM_STR);					//@COD_TRABAJADOR_VENDEDOR='', 
                $stmt->bindParam(67, $vacio  ,PDO::PARAM_STR);					//@COD_ZONA_COMERCIAL='',
                $stmt->bindParam(68, $vacio  ,PDO::PARAM_STR);					//@TXT_ZONA_COMERCIAL='',
                $stmt->bindParam(69, $vacio  ,PDO::PARAM_STR);					//@COD_LOTE_CC='',
                $stmt->bindParam(70, $can_sub_total ,PDO::PARAM_STR);			        //@CAN_SUB_TOTAL=12.0000,

                $stmt->bindParam(71, $valor_cero ,PDO::PARAM_STR);				//@CAN_IMPUESTO_VTA=0, 
                $stmt->bindParam(72, $valor_cero ,PDO::PARAM_STR);				//@CAN_IMPUESTO_RENTA=0,
                $stmt->bindParam(73, $can_total ,PDO::PARAM_STR);				//@CAN_TOTAL=12.0000,
                $stmt->bindParam(74, $valor_cero ,PDO::PARAM_STR);				//@CAN_DSCTO=0,
                $stmt->bindParam(75, $can_tipo_cambio ,PDO::PARAM_STR);			        //@CAN_TIPO_CAMBIO=3.2940,
                $stmt->bindParam(76, $valor_cero ,PDO::PARAM_STR);				//@CAN_PERCEPCION=0, 
                $stmt->bindParam(77, $valor_cero ,PDO::PARAM_STR);				//@CAN_DETRACCION=0,
                $stmt->bindParam(78, $valor_cero ,PDO::PARAM_STR);				//@CAN_RETENCION=0,
                $stmt->bindParam(79, $valor_cero ,PDO::PARAM_STR);				//@CAN_NETO_PAGAR=0,
                $stmt->bindParam(80, $valor_cero ,PDO::PARAM_STR);				//@CAN_TOTAL_COMISION=0,

                $stmt->bindParam(81, $vacio  ,PDO::PARAM_STR);					//@COD_EMPR_BANCO='', 
                $stmt->bindParam(82, $vacio  ,PDO::PARAM_STR);					//@NRO_CUENTA_BANCARIA='',
                $stmt->bindParam(83, $vacio  ,PDO::PARAM_STR);					//@NRO_CARRO='',
                $stmt->bindParam(84, $valor_cero ,PDO::PARAM_STR);				//@IND_VARIAS_ENTREGAS=0,
                $stmt->bindParam(85, $vacio  ,PDO::PARAM_STR);					//@IND_TIPO_COMPRA=' ',
                $stmt->bindParam(86, $vacio  ,PDO::PARAM_STR);					//@NOM_CHOFER_EMPR_TRANSPORTE='', 
                $stmt->bindParam(87, $vacio  ,PDO::PARAM_STR);					//@NRO_ORDEN_CEN='',
                $stmt->bindParam(88, $vacio  ,PDO::PARAM_STR);					//@NRO_LICITACION='',
                $stmt->bindParam(89, $vacio  ,PDO::PARAM_STR);					//@NRO_NOTA_PEDIDO='',
                $stmt->bindParam(90, $vacio  ,PDO::PARAM_STR);					//@NRO_OPERACIONES_CAJA='',

                $stmt->bindParam(91, $vacio  ,PDO::PARAM_STR);					//@TXT_NRO_PLACA='',
                $stmt->bindParam(92, $vacio  ,PDO::PARAM_STR);					//@TXT_CONTACTO='',
                $stmt->bindParam(93, $vacio  ,PDO::PARAM_STR);					//@TXT_MOTIVO_ANULACION='',
                $stmt->bindParam(94, $vacio  ,PDO::PARAM_STR);					//@TXT_CONFORMIDAD='',
                $stmt->bindParam(95, $vacio  ,PDO::PARAM_STR);					//@TXT_A_TIEMPO='',	
                $stmt->bindParam(96, $vacio  ,PDO::PARAM_STR);					//@TXT_DESTINO='', 
                $stmt->bindParam(97, $vacio  ,PDO::PARAM_STR);					//@TXT_TIPO_DOC_ASOC='',
                $stmt->bindParam(98, $vacio  ,PDO::PARAM_STR);					//@TXT_DOC_ASOC='',
                $stmt->bindParam(99, $vacio  ,PDO::PARAM_STR);					//@TXT_ORDEN_ASOC='',
                $stmt->bindParam(100, $cod_categoria_modulo ,PDO::PARAM_STR);	                //@COD_CATEGORIA_MODULO='MSI0000000000010',

                $stmt->bindParam(101, $txt_glosa_atencion ,PDO::PARAM_STR);		        //@TXT_GLOSA_ATENCION=' DE ARROZ AÑEJO X 50 KG (3 x 4), ',
                $stmt->bindParam(102, $vacio  ,PDO::PARAM_STR);					//@TXT_GLOSA='',
                $stmt->bindParam(103, $vacio  ,PDO::PARAM_STR);					//@TXT_TIPO_REFERENCIA='',
                $stmt->bindParam(104, $vacio  ,PDO::PARAM_STR);					//@TXT_REFERENCIA='',
                $stmt->bindParam(105, $vacio  ,PDO::PARAM_STR);					//@COD_OPERACION='',
                $stmt->bindParam(106, $vacio  ,PDO::PARAM_STR);					//@TXT_GRR='', 
                $stmt->bindParam(107, $vacio  ,PDO::PARAM_STR);					//@TXT_GRR_TRANSPORTISTA='',
                $stmt->bindParam(108, $vacio  ,PDO::PARAM_STR);					//@TXT_CTC='',
                $stmt->bindParam(109, $valor_cero ,PDO::PARAM_STR);				//@IND_ZONA=0,
                $stmt->bindParam(110, $valor_cero ,PDO::PARAM_STR);				//@IND_CERRADO=0,

                $stmt->bindParam(111, $vacio  ,PDO::PARAM_STR);					//@COD_EMP_PROV_SERV='', 
                $stmt->bindParam(112, $vacio  ,PDO::PARAM_STR);					//@TXT_EMP_PROV_SERV='',
                $stmt->bindParam(113, $cod_estado ,PDO::PARAM_STR);				//@COD_ESTADO=1,
                $stmt->bindParam(114, $cod_usuario_registro ,PDO::PARAM_STR);	                //@COD_USUARIO_REGISTRO='PHORNALL        ',
                $stmt->bindParam(115, $vacio  ,PDO::PARAM_STR);					//@COD_CTA_GASTO_FUNCION='',
                $stmt->bindParam(116, $vacio  ,PDO::PARAM_STR);					//@NRO_CTA_GASTO_FUNCION='', 
                $stmt->bindParam(117, $cod_categoria_actividad_negocio ,PDO::PARAM_STR);        //@COD_CATEGORIA_ACTIVIDAD_NEGOCIO='VENTA_MERCADERIA',
                $stmt->bindParam(118, $vacio  ,PDO::PARAM_STR);					//@COD_EMPR_PROPIETARIO='',
                $stmt->bindParam(119, $vacio  ,PDO::PARAM_STR);					//@TXT_EMPR_PROPIETARIO='',
                $stmt->bindParam(120, $vacio  ,PDO::PARAM_STR);					//@COD_CATEGORIA_TIPO_COSTEO='',

                $stmt->bindParam(121, $vacio  ,PDO::PARAM_STR);					//@TXT_CATEGORIA_TIPO_COSTEO='', 
                $stmt->bindParam(122, $vacio  ,PDO::PARAM_STR);					//@TXT_CORRELATIVO='',
                $stmt->bindParam(123, $vacio  ,PDO::PARAM_STR);					//@COD_MOVIMIENTO_INVENTARIO_EXTORNADO=default,
                $stmt->bindParam(124, $vacio  ,PDO::PARAM_STR);					//@COD_ORDEN_EXTORNADA=default,
                $stmt->bindParam(125, $valor_cero ,PDO::PARAM_STR);				//@IND_ENV_CLIENTE=0,
        		$stmt->bindParam(126, $vacio  ,PDO::PARAM_STR); 
                $stmt->bindParam(127, $vacio  ,PDO::PARAM_STR);
                $stmt->bindParam(128, $vacio  ,PDO::PARAM_STR);
                $stmt->execute();
                $codorden = $stmt->fetch();

		/**************************************** GUARDAR DETALLE PRODUCTO  *************************************/


		foreach($pedido->detallepedido as $index => $item){

			$COD_PRODUCTO			        =	$item->producto_id;
			$COD_LOTE 				=	'0000000000000000';
			$NRO_LINEA 				= 	(string)($index+1);
			$TXT_NOMBRE_PRODUCTO 			= 	$item->producto->NOM_PRODUCTO;
			$CAN_PRODUCTO 				= 	(string)$item->cantidad;
			$CAN_PESO 				= 	(string)($item->producto->CAN_PESO_MATERIAL*$item->cantidad);
			$CAN_PESO_PRODUCTO 			= 	(string)$item->producto->CAN_PESO_MATERIAL;
			$CAN_TASA_IGV 			        =	'0.1800';
			$CAN_PRECIO_UNIT_IGV 			=	(string)$item->precio;
			$CAN_PRECIO_UNIT 			=	(string)$item->precio;
			$CAN_PRECIO_COSTO 			=	(string)$item->precio;
			$CAN_VALOR_VTA 				=	(string)$item->total;
			$CAN_VALOR_VENTA_IGV 			=	(string)$item->total;
			$CAN_PENDIENTE 				=	(string)$item->cantidad;
			$IND_MATERIAL_SERVICIO 			=	'M';
			$COD_CONCEPTO_CENTRO_COSTO 		=	'IICHCC0000000002';
			$TXT_CONCEPTO_CENTRO_COSTO 		=	'ACOPIO';
			$COD_ESTADO 				=	'1';
			$COD_USUARIO_REGISTRO 			=	Session::get('usuario')->name;


			$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.DETALLE_PRODUCTO_IUD ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?');
        	        $stmt->bindParam(1, $accion ,PDO::PARAM_STR);					//@IND_TIPO_OPERACION='I',
        	        $stmt->bindParam(2, $codorden[0]  ,PDO::PARAM_STR);				//@COD_TABLA='IILMVR0000002923',
        	        $stmt->bindParam(3, $COD_PRODUCTO ,PDO::PARAM_STR); 			        //@COD_PRODUCTO='PRD0000000016186',
        	        $stmt->bindParam(4, $COD_LOTE ,PDO::PARAM_STR);					//@COD_LOTE='0000000000000000', 
        	        $stmt->bindParam(5, $NRO_LINEA ,PDO::PARAM_STR);				//@NRO_LINEA=1, 
        	        $stmt->bindParam(6, $TXT_NOMBRE_PRODUCTO  ,PDO::PARAM_STR); 	                //@TXT_NOMBRE_PRODUCTO='ARROCILLO DE ARROZ AÑEJO X 50 KG',
        	        $stmt->bindParam(7, $vacio  ,PDO::PARAM_STR);					//@TXT_DETALLE_PRODUCTO='',
        	        $stmt->bindParam(8, $CAN_PRODUCTO  ,PDO::PARAM_STR);			        //@CAN_PRODUCTO=1.0000,
        	        $stmt->bindParam(9, $valor_cero  ,PDO::PARAM_STR);				//@CAN_PRODUCTO_ENVIADO=0,
        	        $stmt->bindParam(10, $CAN_PESO  ,PDO::PARAM_STR);				//@CAN_PESO=50.0000,

        	        $stmt->bindParam(11, $CAN_PESO_PRODUCTO ,PDO::PARAM_STR);		        //@CAN_PESO_PRODUCTO=50.0000,
        	        $stmt->bindParam(12, $valor_cero  ,PDO::PARAM_STR);				//@CAN_PESO_ENVIADO=0,
        	        $stmt->bindParam(13, $valor_cero ,PDO::PARAM_STR);				//@CAN_PESO_INGRESO=0, 
        	        $stmt->bindParam(14, $valor_cero ,PDO::PARAM_STR);				//@CAN_PESO_SALIDA=0, 
        	        $stmt->bindParam(15, $valor_cero ,PDO::PARAM_STR);				//@CAN_PESO_BRUTO=0, 
        	        $stmt->bindParam(16, $valor_cero  ,PDO::PARAM_STR); 			        //@CAM_PESO_TARA=0,
        	        $stmt->bindParam(17, $valor_cero  ,PDO::PARAM_STR);				//@CAN_PESO_NETO=0,
        	        $stmt->bindParam(18, $CAN_TASA_IGV  ,PDO::PARAM_STR);			        //@CAN_TASA_IGV=0.1800,
        	        $stmt->bindParam(19, $CAN_PRECIO_UNIT_IGV  ,PDO::PARAM_STR);	                //@CAN_PRECIO_UNIT_IGV=2.0000,
        	        $stmt->bindParam(20, $CAN_PRECIO_UNIT  ,PDO::PARAM_STR);		        //@CAN_PRECIO_UNIT=2.0000,

        	        $stmt->bindParam(21, $valor_cero ,PDO::PARAM_STR);				//@CAN_PRECIO_ORIGEN=0,
        	        $stmt->bindParam(22, $CAN_PRECIO_COSTO  ,PDO::PARAM_STR);		        //@CAN_PRECIO_COSTO=2.0000,
        	        $stmt->bindParam(23, $valor_cero ,PDO::PARAM_STR);				//@CAN_PRECIO_BRUTO=0, 
        	        $stmt->bindParam(24, $valor_cero ,PDO::PARAM_STR); 				//@CAN_PRECIO_KILOS=0,
        	        $stmt->bindParam(25, $valor_cero ,PDO::PARAM_STR);				//@CAN_PRECIO_SACOS=0, 
        	        $stmt->bindParam(26, $CAN_VALOR_VTA  ,PDO::PARAM_STR);			        //@CAN_VALOR_VTA=2.0000, 
        	        $stmt->bindParam(27, $CAN_VALOR_VENTA_IGV  ,PDO::PARAM_STR);	                //@CAN_VALOR_VENTA_IGV=2.0000,
        	        $stmt->bindParam(28, $valor_cero  ,PDO::PARAM_STR);				//@CAN_KILOS=0,
        	        $stmt->bindParam(29, $valor_cero  ,PDO::PARAM_STR);				//@CAN_SACOS=0,
        	        $stmt->bindParam(30, $CAN_PENDIENTE  ,PDO::PARAM_STR);			        //@CAN_PENDIENTE=1.0000,

        	        $stmt->bindParam(31, $valor_cero ,PDO::PARAM_STR);				//@CAN_PORCENTAJE_DESCUENTO=0,
        	        $stmt->bindParam(32, $valor_cero  ,PDO::PARAM_STR);				//@CAN_DESCUENTO=0,
        	        $stmt->bindParam(33, $valor_cero ,PDO::PARAM_STR);				//@CAN_ADELANTO=0, 
        	        $stmt->bindParam(34, $vacio ,PDO::PARAM_STR);					//@TXT_DESCRIPCION='', 
        	        $stmt->bindParam(35, $IND_MATERIAL_SERVICIO ,PDO::PARAM_STR);	                //@IND_MATERIAL_SERVICIO='M' 
        	        $stmt->bindParam(36, $valor_cero  ,PDO::PARAM_STR);				//@IND_IGV=0, 
        	        $stmt->bindParam(37, $vacio  ,PDO::PARAM_STR);					//@COD_ALMACEN='',
        	        $stmt->bindParam(38, $vacio  ,PDO::PARAM_STR);					//@TXT_ALMACEN='',
        	        $stmt->bindParam(39, $vacio  ,PDO::PARAM_STR);					//@COD_OPERACION='',
        	        $stmt->bindParam(40, $vacio  ,PDO::PARAM_STR);					//@COD_OPERACION_AUX='',

        	        $stmt->bindParam(41, $vacio ,PDO::PARAM_STR);					//@COD_EMPR_SERV='',
        	        $stmt->bindParam(42, $vacio  ,PDO::PARAM_STR);					//@TXT_EMPR_SERV='',
        	        $stmt->bindParam(43, $vacio ,PDO::PARAM_STR);					//@NRO_CONTRATO_SERV='', 
        	        $stmt->bindParam(44, $vacio ,PDO::PARAM_STR);					//@NRO_CONTRATO_CULTIVO_SERV='', 
        	        $stmt->bindParam(45, $vacio ,PDO::PARAM_STR);					//@NRO_HABILITACION_SERV='', 
        	        $stmt->bindParam(46, $valor_cero  ,PDO::PARAM_STR);				//@CAN_PRECIO_EMPR_SERV=0, 
        	        $stmt->bindParam(47, $vacio  ,PDO::PARAM_STR);					//@NRO_CONTRATO_GRUPO='',
        	        $stmt->bindParam(48, $vacio  ,PDO::PARAM_STR);					//@NRO_CONTRATO_CULTIVO_GRUPO='',
        	        $stmt->bindParam(49, $vacio  ,PDO::PARAM_STR);					//@NRO_HABILITACION_GRUPO='',
        	        $stmt->bindParam(50, $vacio  ,PDO::PARAM_STR);					//@COD_CATEGORIA_TIPO_PAGO='',

        	        $stmt->bindParam(51, $vacio ,PDO::PARAM_STR);					//@COD_USUARIO_INGRESO='',
        	        $stmt->bindParam(52, $vacio  ,PDO::PARAM_STR);					//@COD_USUARIO_SALIDA='',
        	        $stmt->bindParam(53, $vacio ,PDO::PARAM_STR);					//@TXT_GLOSA_PESO_IN='', 
        	        $stmt->bindParam(54, $vacio ,PDO::PARAM_STR);					//@TXT_GLOSA_PESO_OUT='', 
        	        $stmt->bindParam(55, $COD_CONCEPTO_CENTRO_COSTO ,PDO::PARAM_STR);               //@COD_CONCEPTO_CENTRO_COSTO='IICHCC0000000002', 
        	        $stmt->bindParam(56, $TXT_CONCEPTO_CENTRO_COSTO  ,PDO::PARAM_STR);              //@TXT_CONCEPTO_CENTRO_COSTO='ACOPIO', 
        	        $stmt->bindParam(57, $vacio  ,PDO::PARAM_STR);					//@TXT_REFERENCIA='',
        	        $stmt->bindParam(58, $vacio  ,PDO::PARAM_STR);					//@TXT_TIPO_REFERENCIA='',
        	        $stmt->bindParam(59, $vacio  ,PDO::PARAM_STR);					//@IND_COSTO_ARBITRARIO='',
        	        $stmt->bindParam(60, $COD_ESTADO  ,PDO::PARAM_STR);				//@COD_ESTADO=1,


        	        $stmt->bindParam(61, $COD_USUARIO_REGISTRO ,PDO::PARAM_STR);	                 //@COD_USUARIO_REGISTRO='PHORNALL',
        	        $stmt->bindParam(62, $vacio  ,PDO::PARAM_STR);					//@COD_TIPO_ESTADO='',
        	        $stmt->bindParam(63, $vacio ,PDO::PARAM_STR);					//@TXT_TIPO_ESTADO='', 
        	        $stmt->bindParam(64, $vacio ,PDO::PARAM_STR);					//@TXT_GLOSA_ASIENTO='', 
        	        $stmt->bindParam(65, $vacio ,PDO::PARAM_STR);					//@TXT_CUENTA_CONTABLE='', 
        	        $stmt->bindParam(66, $vacio  ,PDO::PARAM_STR); 					//@COD_ASIENTO_PROVISION='',
        	        $stmt->bindParam(67, $vacio  ,PDO::PARAM_STR);					//@COD_ASIENTO_EXTORNO='',
        	        $stmt->bindParam(68, $vacio  ,PDO::PARAM_STR);					//@COD_ASIENTO_CANJE='',
        	        $stmt->bindParam(69, $vacio  ,PDO::PARAM_STR);					//@COD_TIPO_DOCUMENTO='',
        	        $stmt->bindParam(70, $vacio  ,PDO::PARAM_STR);					//@COD_DOCUMENTO_CTBLE='',


        	        $stmt->bindParam(71, $vacio ,PDO::PARAM_STR);					//@TXT_SERIE_DOCUMENTO='',
        	        $stmt->bindParam(72, $vacio  ,PDO::PARAM_STR);					//@TXT_NUMERO_DOCUMENTO='',
        	        $stmt->bindParam(73, $vacio ,PDO::PARAM_STR);					//@COD_GASTO_FUNCION='', 
        	        $stmt->bindParam(74, $vacio ,PDO::PARAM_STR);					//@COD_CENTRO_COSTO='', 
        	        $stmt->bindParam(75, $vacio ,PDO::PARAM_STR);					//@COD_ORDEN_COMPRA='', 
        	        $stmt->bindParam(76, $fecha_ilimitada  ,PDO::PARAM_STR);		        //@FEC_FECHA_SERV='1901-01-01', 
        	        $stmt->bindParam(77, $vacio  ,PDO::PARAM_STR);					//@COD_CATEGORIA_TIPO_SERV_ORDEN='',
        	        $stmt->bindParam(78, $vacio  ,PDO::PARAM_STR);					//@IND_GASTO_COSTO=' ',
        	        $stmt->bindParam(79, $valor_cero  ,PDO::PARAM_STR);				//@CAN_PORCENTAJE_PERCEPCION=0,
        	        $stmt->bindParam(80, $valor_cero  ,PDO::PARAM_STR);				//@CAN_VALOR_PERCEPCION=0
        	        $stmt->execute();


		}

		$this->orden_id 		= 	$codorden[0];
		return true;


	}	






}


