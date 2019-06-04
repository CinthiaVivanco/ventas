<div class="po-title">
    <div class="cell-detail">
    	<strong>	
	      	<span>{{$cliente->NOM_EMPR}}</span> , 
	      	<span class="cell-detail-description">{{$producto->NOM_PRODUCTO}}</span>
		</strong>
    </div>
</div> 
<div class="po-body">

	<h2 class='informacion-po'>INFORMACION</h2>

    @if($regla->tiporegla == 'NEG') 
		<h4 class='po-regla-descripcion nombre-po'>
			<strong>Nombre : </strong><small>{{$regla->nombre}}</small>
		</h4>

		<h4 class='po-regla-descripcion nombre-po'>
			<strong>Codigo : </strong><small>{{$regla->codigo}}</small>
		</h4>

    @else 
	    @if($regla->tiporegla == 'CUP') 

			<h4 class='po-regla-descripcion nombre-po'>
				<strong>Nombre : </strong><small>{{$regla->nombre}}</small>
			</h4>
			<h4 class='po-regla-descripcion nombre-po'>
				<strong>Codigo : </strong><small>{{$regla->codigo}}</small>
			</h4>
			<h4 class='po-regla-descripcion nombre-po'>
				<strong>Descripción : </strong><small>{{$regla->descripcion}}</small>
			</h4>
			<h4 class='po-regla-descripcion nombre-po'>
				<strong>Cupón : </strong><small>{{$regla->cupon}}</small>
			</h4>			
	    @else 
			<h4 class='po-regla-descripcion nombre-po'>
				<strong>Nombre : </strong><small>{{$regla->nombre}}</small>
			</h4>
			<h4 class='po-regla-descripcion nombre-po'>
				<strong>Codigo : </strong><small>{{$regla->codigo}}</small>
			</h4>

			<h4 class='po-regla-descripcion nombre-po'>
				<strong>Afecta : </strong><small>
		            @if($regla->documento == 'OV') 
		              ORDEN VENTA
		            @else 
		              NOTA CREDITO 
		            @endif
				</small>
			</h4>
	    @endif
    @endif




	<h2 class='condicion-po'>CONDICIONES</h2>


    @if($regla->tiporegla == 'CUP') 

		<h4 class='po-regla-descripcion fechainicio-po'>
			<strong>Fecha Inicio : </strong><small>{{date_format(date_create($regla->fechainicio), 'd-m-Y H:i')}}</small>
		</h4>
		<h4 class='po-regla-descripcion fechafin-po'>
			<strong>Fecha Fin : </strong><small>
		        @if($regla->fechafin == $fechavacia) 
		          <span class="label label-default">ilimitado</span> 
		        @else 
		          {{date_format(date_create($regla->fechafin), 'd-m-Y H:i')}}
		        @endif
	        </small>
		</h4>


		<h4 class='po-regla-descripcion cantidadminima-po'>
			<strong>Cantidad minima : </strong><small>
		        @if($regla->cantidadminima == 0) 
		          <span class="label label-default">ilimitado</span> 
		        @else 
		          <span class="badge badge-default">{{$regla->cantidadminima}}</span>
		        @endif
	        </small>
		</h4>

	
		<h4 class='po-regla-descripcion cantidadminima-po'>
			<strong>Total disponible : </strong><small>
		        @if($regla->totaldisponible == 0) 
		          <span class="label label-default">ilimitado</span> 
		        @else 
		          <span class="badge badge-default">{{$regla->totaldisponible}}</span>
		        @endif
	        </small>
		</h4>

		<h4 class='po-regla-descripcion cantidadminima-po'>
			<strong>Total disponible para cada usuario : </strong><small>
		        @if($regla->totalcadacuenta == 0) 
		          <span class="label label-default">ilimitado</span> 
		        @else 
		          <span class="badge badge-default">{{$regla->totalcadacuenta}}</span>
		        @endif
	        </small>
		</h4>

    @else 

		<h4 class='po-regla-descripcion fechainicio-po'>
			<strong>Fecha Inicio : </strong><small>{{date_format(date_create($regla->fechainicio), 'd-m-Y H:i')}}</small>
		</h4>
		<h4 class='po-regla-descripcion fechafin-po'>
			<strong>Fecha Fin : </strong><small>
		        @if($regla->fechafin == $fechavacia) 
		          <span class="label label-default">ilimitado</span> 
		        @else 
		          {{date_format(date_create($regla->fechafin), 'd-m-Y H:i')}}
		        @endif
	        </small>
		</h4>


		<h4 class='po-regla-descripcion cantidadminima-po'>
			<strong>Cantidad minima : </strong><small>
		        @if($regla->cantidadminima == 0) 
		          <span class="label label-default">ilimitado</span> 
		        @else 
		          <span class="badge badge-default">{{$regla->cantidadminima}}</span>
		        @endif
	        </small>
		</h4>

    @endif



	<h2 class='accion-po'>ACCIONES</h2>

    @if($regla->tiporegla == 'NEG') 
		<h4 class='po-regla-descripcion monto-po'>
			<strong>Negociación : </strong><small>{{$regla->descuento}}</small>
		</h4>
    @else 

		<h4 class='po-regla-descripcion monto-po'>
			<strong>Acción : </strong><small>
					<!-- ETIQUETA PARA AUMENTO Y DESCUENTO -->
				@if ($regla->descuentoaumento == 'AU')
					aumento
				@else
					descuento
				@endif
			</small>
		</h4>

		<h4 class='po-regla-descripcion monto-po'>
			<strong>Tipo descuento : </strong><small>
		        @if($regla->tipodescuento == 'IMP') 
		          importe
		        @else 
		          porcentaje
		        @endif
			</small>
		</h4>
		<h4 class='po-regla-descripcion monto-po'>
			<strong>Monto : </strong><small>{{$regla->descuento}}</small>
		</h4>
    @endif

	<h4 class='po-regla-descripcion monto-po'>
		<strong>Calculo : </strong>
		<small>
			{{$funcion->funciones->calculo_precio_regla($regla->tipodescuento,$producto->precio,$regla->descuento,$regla->descuentoaumento)}}
		</small>
	</h4>


</div>