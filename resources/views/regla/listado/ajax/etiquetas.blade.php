<div class='etiquetas-reglas'>
	@foreach($listareglaproductoclientes as $item)
        @if ($item->producto_id == $producto_id && $item->cliente_id == $cliente_id && $tipo == $item->regla->tiporegla && $item->contrato_id == $contrato_id) 
        	<div class='etiquetas-reglas-modal'>
			  	<span class="label label-{{$color}} label-etiqueta po-detalle{{$item->id}}"
			  		  data_id='{{$item->id}}'
			  		  data_sw='0'
			  		  data_regla='{{$item->regla_id}}'
			  		  data-toggle='popovers'>
			  		{{$item->nombre}}
			  	</span>
				@include('regla.listado.ajax.etiquetadescuentoaumento')        		
        	</div>
        @endif
	@endforeach
</div>



