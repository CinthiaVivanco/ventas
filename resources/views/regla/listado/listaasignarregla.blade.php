<table class="table table-striped table-borderless">
  <thead>

    <tr>
      <th colspan="2" class='center columna_1'>DATOS FILTRO</th>       
      <th colspan="4" class='center columna_1'>REGLAS</th>                    
    </tr> 

    <tr>
      <th class='columna_1'>Nombre</th>
      <th class='columna_1'>Precio</th>
      <th class='columna_2 success'>Negociación</th>
      <th class='columna_2'>Precio</th>
      <th class='columna_2 warning'>Nota Credito</th>
      <th class='columna_2 danger'>Cupón</th>
    </tr>
  </thead>
  <tbody class="no-border-x">
    @foreach($listadeproductos as $itemproducto)
      @foreach($listacliente as $index => $item)
      <tr   class='fila_regla'
            data_producto='{{$itemproducto->COD_PRODUCTO}}'
            data_cliente='{{$item->id}}'
      >
        <td class="cell-detail">
          <span>{{$item->NOM_EMPR}}</span>
          <span class="cell-detail-description-producto">{{$itemproducto->NOM_PRODUCTO}}</span>
          <span class="cell-detail-description-contrato">{{$item->CONTRATO}}</span>
        </td>
        <td class="cell-detail">
          <strong>{{$itemproducto->precio}}</strong>
        </td>
        <td class="relative">

            <div  class='etneg{{$itemproducto->COD_PRODUCTO}}{{$item->id}}'
                  data_fila='neg'>


                @include('regla.listado.ajax.etiquetas',
                         [
                          'producto_id'                     => $itemproducto->COD_PRODUCTO,
                          'cliente_id'                      => $item->id,
                          'listareglaproductoclientes'      => $listareglaproductoclientes,
                          'tipo'                            => 'NEG',
                          'color'                           => 'success'
                         ])

            </div>

            <span class="badge badge-success popover-edit"
                  data_nombre='NEGOCIACION'
                  data_nombreselect='negociacion'
                  data_tipo='NEG'
                  data_prefijo='neg'
                  data_color='success'
                  data_color_modal='colored-header-success'>
              <span 
                    class="md-trigger icon mdi mdi-edit  popover-negociacion-x" 
              ></span>
            </span>

        </td>
        <td class="relative">

            <div class='etpov{{$itemproducto->COD_PRODUCTO}}{{$item->id}}'
                 data_fila='pov'>

                @include('regla.listado.ajax.etiquetas',
                         [
                          'producto_id'                     => $itemproducto->COD_PRODUCTO,
                          'cliente_id'                      => $item->id,
                          'listareglaproductoclientes'      => $listareglaproductoclientes,
                          'tipo'                            => 'POV',
                          'color'                           => 'primary'
                         ])

            </div>

            <span class="badge badge-primary popover-edit"
                  data_nombre='PRECIO'
                  data_nombreselect='precio'
                  data_tipo='POV'
                  data_prefijo='pov'
                  data_color='primary'
                  data_color_modal='colored-header-primary'>
              <span 
                    class="md-trigger icon mdi mdi-edit popover-precio-ov-x" 
              ></span>
            </span>


        </td>
        <td class="relative">
          
            <div class='etpnc{{$itemproducto->COD_PRODUCTO}}{{$item->id}}'
                 data_fila='pnc'>

                @include('regla.listado.ajax.etiquetas',
                         [
                          'producto_id'                     => $itemproducto->COD_PRODUCTO,
                          'cliente_id'                      => $item->id,
                          'listareglaproductoclientes'      => $listareglaproductoclientes,
                          'tipo'                            => 'PNC',
                          'color'                           => 'warning'
                         ])

            </div>

            <span class="badge badge-warning popover-edit"
                  data_nombre='NOTA CREDITO'
                  data_nombreselect='nota credito'
                  data_tipo='PNC'
                  data_prefijo='pnc'
                  data_color='warning'
                  data_color_modal='colored-header-warning'>
              <span 
                    class="md-trigger icon mdi mdi-edit popover-precio-nc-x" 
              ></span>
            </span>


        </td>
        <td class="relative">

            <div class='etcup{{$itemproducto->COD_PRODUCTO}}{{$item->id}}'
                 data_fila='cup'>

                @include('regla.listado.ajax.etiquetas',
                         [
                          'producto_id'                     => $itemproducto->COD_PRODUCTO,
                          'cliente_id'                      => $item->id,
                          'listareglaproductoclientes'      => $listareglaproductoclientes,
                          'tipo'                            => 'CUP',
                          'color'                           => 'danger'
                         ])

            </div>

            <span class="badge badge-danger popover-edit"
                  data_nombre='CUPON'
                  data_nombreselect='cupon'
                  data_tipo='CUP'
                  data_prefijo='cup'
                  data_color='danger'
                  data_color_modal='colored-header-danger'>
              <span 
                    class="md-trigger icon mdi mdi-edit popover-cupon-x" 
              ></span>
            </span>

        </td>
      </tr>
      @endforeach
    @endforeach
                          
  </tbody>
</table> 

<div class="registrocount col-sm-5" >
  Mostrando un total de {!! $listacliente->count()*10 !!} registros
</div>
<div class="col-sm-7">
{!! $listacliente->appends(Request::only(['cliente_select','producto_select']))->render() !!}
</div>