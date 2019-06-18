<div class="modal-header">
  <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
  <h3 class="modal-title"><strong>{{$pedido->empresa->NOM_EMPR}}</strong></h3>
  <h5 class="modal-title">{{$pedido->empresa->NRO_DOCUMENTO}} / {{$funcion->funciones->cuenta_cliente($pedido->cliente_id)}}</h5>

  <h5 class="modal-title"> Dirección entrega : {{$pedido->direccionentrega->NOM_DIRECCION}}</h5>
</div>
<div class="modal-body">


  	<table class="table">
	    <thead>
	      <tr>
		    <th>Cantidad</th>
	        <th>Producto</th>
	        <th>Precio</th>
	        <th>Importe</th>
	      </tr>
	    </thead>
	    <tbody>

	   @foreach($pedido->detallepedido as $item)
		      <tr>
		        <td>{{$item->cantidad}}</td>
		        <td>{{$item->producto->NOM_PRODUCTO}}</td>
		        <td>{{$item->precio}}</td>
		        <td>{{$item->total}}</td>
		      </tr>                    
	    @endforeach

	    </tbody>
	    <tfooter>
	      <tr>
		    <th colspan="3"></th>
	        <th>{{$pedido->total}}</th>
	      </tr>
	    </tfooter>
  	</table>


</div>
<div class="modal-footer">
  <button type="button" data-dismiss="modal" class="btn btn-default modal-close">Cancelar</button>
</div>