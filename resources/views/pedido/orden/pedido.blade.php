<div class="row detallecliente">
  <!-- DATOS DEL CLIENTE -->
</div>
<div class="row detalleproducto">
  <!-- DATOS DEL PRODUCTO -->
  
  <!--<div class="col-sm-12">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading cell-detail">
        Nombre Producto
        <div class="tools">
          <span class="icon mdi mdi-close"></span>
        </div>
        <span class="panel-subtitle cell-detail-description-producto">Unidad medida</span>
        <span class="panel-subtitle cell-detail-description-contrato">precio</span>
      </div>
    </div>
  </div> -->              
</div>

<div class='row-menu'>
  <div class='row'>
    <div class="col-sm-12 col-mobil-top">
      <div class="col-fr-2 col-atras">
        <span class="mdi mdi-arrow-left"></span>
      </div> 
      <div class="col-fr-10 col-total">
        <strong>Total : </strong> <strong class='total'> 0.00</strong>
      </div> 
    </div>
  </div>
</div>



<form method="POST" action="{{ url('/agregar-orden-pedido/'.$idopcion) }}" class="form-horizontal group-border-dashed form-pedido">
  {{ csrf_field() }}
  <input type="hidden" name="cliente" id='cliente'>
  <input type="hidden" name="cuenta" id='cuenta'>
  <input type="hidden" name="direccion_entrega" id='direccion_entrega'>
  <input type="hidden" name="productos" id='productos'>

  <button type="submit" class="btn btn-space btn-success btn-big btn-guardar">
    <i class="icon mdi mdi-check"></i> Guardar
  </button>

</form>

